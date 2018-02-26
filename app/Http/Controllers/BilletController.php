<?php

namespace App\Http\Controllers;

use App\User;
use App\Billet;
use App\Transaction;

use App\CAS;
use App\Payutc\Payutc;
use App\Ginger\GingerClient as Ginger;

use App\Http\Requests\InfosAchat;
use Illuminate\Http\Request;
use App\Http\Requests\ModifyRequest;
use App\Notifications\BilletAchete;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class BilletController extends Controller
{
// ================================================================================
// ========== ACHATS		========================================
// ================================================================================
/**/
	// Page d'accueil
	public function home() {
		return view('pages.home');		
	}

	// Entrée des infos pour achat
	public function select()
	{
		$tarifsArr 	= config("billets.tarifsArr");
		$tarifs 	= config("billets.tarifs");
		$nomSeances = config("billets.seances");
		$prix 		= config("billets.prix");
		$nbBilletsRestant = Billet::getRestants();
		return view('pages.select', compact('nbBilletsRestant' ,'prix', 'tarifs', 'tarifsArr', 'nomSeances'));
	}

	// Achat du billet avec les infos
	public function verifSelect(InfosAchat $request)
	{
		// Soldout !!
		return back()->withInput()->withErrors("Toutes les places ont été vendues ! Merci beaucoup !");

	// ========== VERIFICATION BILLETS SELECTIONNES	========================================

		// Constantes de vérification
		$nbBilletsRestant = Billet::getRestants();
		$prixStock 	= config("billets.prix");
		$nomSeances = config("billets.seances");
		$tarifsArr 	= config("billets.tarifsArr");
		$billetsSelected = [];
		foreach ($tarifsArr as $tarif) $billetsSelected[$tarif] = 0;

		// Vérifications places séances
		$seancesPrises = [0,0,0];
		foreach ($request->input("billet") as $billet) {
			$seancesPrises[intval($billet['seance'])]++;		// Place pour la séance
			$billetsSelected[$billet['tarif']]++;				// Ajout des billets pour la transaction
		}

		// Vérification 1 cotisant et étudiant max 
		if ($billetsSelected['cotisant'] + $billetsSelected['etudiant'] > 1)
			return back()->withInput()->withErrors("Vous ne pouvez prendre qu'une place au tarif cotisant ou étudiant par compte au maximum.");

		// Vérification nombre de billet suffisant
		for ($i = 0; $i <= 2; $i++)
			if ($nbBilletsRestant[$i] < $seancesPrises[$i])
				return back()->withInput()->withErrors("Nombre de billets restants insuffisant pour la séance du $nomSeances[$i], il ne reste que $nbBilletsRestant[$i] billets.");


	// ========== VERIFICATION CLIENT	========================================

		// Vérification client actuellement connecté
		if ($request->input('connected') == "1") {
			$client = Auth::user();
			if (!$client)
				return back()->withInput()->withErrors("Erreur de connexion, veuillez vous déconnecter puis recommencer.");
		} else {
			$client = User::where('email', $request->input('email'))->first();

			if ($request->input('new-client') == "1")		// Vérification nouveau client
			{
				if ($client == NULL) {			// Client n'existe pas		=> Stockage
					$client = User::create([
						'prenom' 	=> $request->input('client-prenom'),
						'nom' 		=> $request->input('client-nom'),
						'email' 	=> $request->input('email'),
						'password' 	=> Hash::make($request->input('password'))
					]);
				} else							// Erreur : le client existe déjà
					return back()->withInput()->withErrors("L'adresse mail est déjà utilisée, veuillez cocher \"J'ai déjà réalisé un achat\".");

			}
			else											// Vérification client existant
			{
				if ($client == NULL)		// Client introuvable
					return back()->withInput()->withErrors("L'adresse mail est inconnue.");
				else						// Client existe
					if (!Hash::check($request->input('password'), $client->password))		// Vérification mot de passe
						return back()->withInput()->withErrors("Mauvais email / mot de passe.");
			}

			Auth::login($client);			// On loggue le client
		}
		// Ici le client est loggué et présent dans la BDD


	// ========== VERIFICATION TRANSACTIONS EN COURS	========================================
		$transEnCours = $client->transactions()->where('etat', 'W')->first();
		if ($transEnCours)
			return back()->withInput()->withErrors("Vous avez une commande en cours, <a href='" . route('validationTransaction') . "'>veuillez l'annuler ou la payer ici</a> avant de recommander d'autres billets.");

	// ========== VERIFICATION TARIFS	========================================

		$billetsEnCours = $client->billets()->notCanceled()->get();
		
		// Vérification doublon cotisant ou étudiant par soirée
		foreach ($request->input("billet") as $billet)
			if ($billet['tarif'] == 'cotisant' || $billet['tarif'] == 'etudiant')
				if ($billetsEnCours->where('seance', $billet['seance'])->whereIn('tarif', ['cotisant', 'etudiant'])->first())
					return back()->withInput()->withErrors("Vous ne pouvez pas avoir une place au tarif cotisant et une autre au tarif étudiant ou deux fois un de ces deux tarifs pour le même soir.");

		if ($billetsSelected['cotisant'] > 0)
		{
			// Vérification CAS
			if (!$client->login)		// Si pas de login dans la BDD
			{
				if (!session()->has('login'))		// Si l'utilisateur n'a pas déjà été connecté, on passe par login CAS
					return redirect()->route('loginCas');

				// Vérification du login
				$doublonLogin = User::where('login', session('login'))->first();

				if ($doublonLogin)
					return back()->withInput()->withErrors("Ce login CAS est déjà utilisé pour un autre compte.");
				$client->login = session('login');
				$client->save();
			}

			// Vérification cotisant
			$ginger = new Ginger(config('billets.ginger_key'));
			$isCotisant = $ginger->getUser($client->login)['is_cotisant'];

			if (!$isCotisant)
				return back()->withInput()->withErrors("Vous n'êtes pas cotisant.");	
		}

		if ($billetsSelected['etudiant'] > 0)
		{
			// Vérification mail
			$mail = $client->email;
			$endMail = substr($mail, strrpos($mail,'@'));
			$mails_etu = config("billets.mails_etu");
			if(!in_array($endMail, $mails_etu))
				return back()->withInput()->withErrors("Votre adresse mail doit être celle d'une école partenaire ('".implode('\', \'', $mails_etu)."')");
		}


	// ========== CREATION ET STOCKAGE COMMANDE	========================================

		$transactionPayutc = $this->createTransaction($billetsSelected, $client);

		// Stockage de la Transaction		
		$transaction = Transaction::create([
			'id' 		=> $transactionPayutc->tra_id,
			'etat' 		=> 'W',
			'user_id' 	=> $client->id
		]);

		// Stockage des Billets
		foreach ($request->input("billet") as $billet) {
			$billet = Billet::create([
				'qr'		=> str_random(32),
				'tarif' 	=> $billet['tarif'],
				'seance' 	=> $billet['seance'],
				'prenom' 	=> $billet['prenom'],
				'nom' 		=> $billet['nom'],
				'transaction_id' => $transactionPayutc->tra_id
			]);
		}

		// Redirection pour paiement
		return redirect($transactionPayutc->url);
	}




	public function loginCas($redirRoute = NULL)
	{
		// Routes
		$service = url()->current();
		if ($redirRoute)
			$service .= '?redirRoute='.$redirRoute;
		$redirectCAS = config("billets.cas.login").$service;

		if ( !isset($_GET['ticket']) || empty($_GET['ticket'] ) ) 	// Si pas de session ni GET
			return redirect($redirectCAS);

		// Vérification du CAS
		$data = \App\CAS::authenticate($service, $_GET['ticket']);
		$login = $data['cas:user'];
		if (!$login)
			return redirect($redirectCAS);

		// Garde la session CAS
		session()->put('login', $login);
		session()->put('email', $data['cas:attributes']['cas:mail']);
		session()->put('prenom',$data['cas:attributes']['cas:givenName']);
		session()->put('nom', 	$data['cas:attributes']['cas:sn']);

		// Redirection vers la route ou select
		if ($redirRoute || isset($_GET['redirRoute'])) {
			$redirRoute = $_GET['redirRoute'];
			return redirect()->route($redirRoute);
		} else
			return redirect()->route('select');
	}

// ================================================================================
// ========== TRANSACTIONS	========================================
// ================================================================================
/**/
	// Valide ou non les transactions
	public function validationTransaction()
	{
		// Récupération des transactions (en attente) de l'utilisateur
		$client = Auth::user();
		$transactions = $client->transactions()->get();

		// Récupération des transactions correspondantes de Payutc
		if (!$transactions->isEmpty()) {
			foreach ($transactions as $trans) {

				// On bypass les transactions annulées (ou déjà validées)
				if ($trans->etat == 'A' || $trans->etat == 'V')
					continue;

				$transPayutc = $this->checkTransaction($trans->id);

				if ($trans->etat == 'W' && $transPayutc->status == 'V')		// Transaction fraichement validée
					\Notification::send($client, new BilletAchete($trans->id));

				// Mise à jour de la BDD
				$trans->etat = $transPayutc->status;
				$trans->save();
			}
		}
		return view('pages.validate', compact('transactions'));
	}

	// Retourner au paiement d'une transaction
	public function pay($tra_id)
	{
		$transaction = Transaction::where('user_id', Auth::id())->where('etat', '<>', 'A')->find($tra_id);

		if ($transaction)
			return redirect(config("billets.payutc.trans_url") . $transaction->id);
		else
			return back()->withInput()->withErrors("Transaction $tra_id introuvable.");
	}

	// Annuler une transaction
	public function cancel($tra_id)
	{
		$transaction = Transaction::where('user_id', Auth::id())->find($tra_id);
		if ($transaction) {
			$transaction->etat = 'A';
			$transaction->save();
			return redirect()->route('validationTransaction');
		}
			return back()->withInput()->withErrors("Transaction $tra_id introuvable.");
		
	}

// ================================================================================
// ========== BILLETS		========================================
// ================================================================================
/**/

	public function show()
	{
		$client = Auth::user();
		$billets = $client->billets()->where('etat', 'V')->get();
		$seances = config('billets.seances');
		$tarifs = config('billets.tarifs');
		return view('pages.show', compact('billets', 'seances', 'tarifs'));
	}

	public function generate($billet_id)
	{
		$client = Auth::user();
		$billet = $client->billets()->where('etat', 'V')->where('billets.id', $billet_id)->get();
		if ($billet->isEmpty())
			return redirect()->route('show');

		return $this->generatePDF($billet, $client->email);
	}

	public function generateAll()
	{
		$client = Auth::user();
		$billets = $client->billets()->where('etat', 'V')->get();
		if ($billets->isEmpty())
			return "Erreur, vous n'avez pas de billets";

		return $this->generatePDF($billets, $client->email);
	}


	public function modify(ModifyRequest $request)
	{
		$billet = Auth::user()->billets->find($request->id);
		if (!$billet)
			return back()->withErrors('Billet introuvable');
		$billet->prenom = $request->prenom;
		$billet->nom = $request->nom;
		if ($request->navette == "1")
			$billet->navette = 1;
		if ($request->navette == "0")
			$billet->navette = 0;

		$billet->save();
		return redirect()->route('show');
	}

// ================================================================================
// ========== QR CODE		========================================
// ================================================================================
/**/
	public function getQR($key, $hash)
	{
		$billet = $this->checkQR($key, $hash);
		if (get_class($billet) == "Illuminate\Http\JsonResponse")
			return $billet;

		$seancesTimestamp = [
			1513267200,
			1513353600,
			1513440000
		];

		return response()->json([
			'id'			=> $billet->qr,
			'reservation_id'=> $billet->id,
			'username' 	 	=> $billet->prenom . " " . $billet->nom,
			'seance' 		=> config("billets.seances.".$billet->seance),
			'type'  		=> config("billets.tarifs.".$billet->tarif),
			'creation_date' => $seancesTimestamp[$billet->seance],
			'expires_at' 	=> $seancesTimestamp[$billet->seance] + 14400
		], 200);
	}

	public function validateForce(Request $request) {
		$id = filter_var($request->input("id"), FILTER_SANITIZE_NUMBER_INT);
		if (!$id)
			return view('admin.validate')->withErrors("Bad input");

		$billet = Billet::find($id);
		if (!$billet)
			return view('admin.validate')->withErrors("Billet non trouvé");
		$billet->present = 1;
		$billet->save();

		$request->session()->flash('success', 'Billet validé!');
		return view('admin.validate');
	}

	public function validateQR($key, $hash)
	{
		$billet = $this->checkQR($key, $hash);
		if (get_class($billet) == "Illuminate\Http\JsonResponse")
			return $billet;

		$billet->present = 1;
		$billet->save();
		dd($billet->present);
		return response()->json([
			'message' => 'Merci'
		], 200);
	}


	private function checkQR($key, $hash)
	{
		if ($key != config('billets.qr_api_key'))
			return response()->json([
				'type' => 'error',
				'message' => 'Forbidden access'
			], 403);

		$billet = \App\Billet::where('qr', $hash)->first();

		if (!$billet)
			return response()->json([
				'type' => 'error',
				'message' => 'Billet not found'
			], 404);

		if ($billet->transaction()->first()->etat != 'V')
			return response()->json([
				'type' => 'error',
				'message' => 'Billet non valide'
			], 404);

		return $billet;
	}


// ================================================================================
// ========== FONCTIONS PRIVEES		========================================
// ================================================================================
/**/
	// Retourne la transaction créée avec les $billets[tarif => quantite]
	private function createTransaction($billets, $client) {

		$payutc = Payutc::createPayutc();
		$items = [];
		$productsID = config("billets.payutc.productsID");

		// Formatage des billets
		foreach ($billets as $tarif => $quantite)
			if ($quantite > 0)
				array_push($items, [$productsID[$tarif], $quantite]);

		// Création de la transaction
		$transaction = $payutc->apiCall('WEBSALE', 'createTransaction',
			[
				'items' 		=> json_encode($items),
				'mail' 			=> $client->email,
				'return_url' 	=> route('validationTransaction'),
				'fun_id' 		=> config("billets.payutc.fun_id")
			]
		);

		return $transaction;
	}

	private function checkTransaction($id) {
		$payutc = Payutc::createPayutc();
		return $payutc->apiCall('WEBSALE', 'getTransactionInfo',
			[
				'fun_id' 		=> config("billets.payutc.fun_id"),
				'tra_id' 		=> $id
			]
		);
	}

	public static function generatePDF($billets, $mail) {

		$pdf = new \FPDF('P','mm','A4');
		$i = 0;
		$tarifs  = config("billets.tarifs");
		$prix  	 = config("billets.prix");
		$seances = config("billets.seances");

		foreach ($billets as $billet) {

			// Deux billets par pages
			$i++;
			if ($i % 2 == 1) {		// Billet en haut
				$pdf->AddPage();
				$offsetDuo = 0;
			} else {				//Billet en bas
				// $pdf->SetDrawColor(150,150,150);
				$offsetDuo = 148;
				$pdf->line(0, $offsetDuo, 210, $offsetDuo);
			}

			// Traitement
			$id = sprintf("%05d", $billet->id);
			$pre_nom =  $billet->prenom . ' ' . strtoupper($billet->nom);
			$filename = 'Billet_Comedmus_2017_' . $id . '.pdf';

			// Settings of pdf
			$pdf->SetTitle(utf8_decode($filename), true);
			$pdf->SetFillColor(255);
			$pdf->Image(resource_path('PDF/billet_proto.png'), 10, $offsetDuo + 15, 190); // Le fond image du pdf

			// Affichage Séance
			$pdf->SetFont('Helvetica','',14);
			$pdf->SetXY(27.5, $offsetDuo + 49.75);
			$pdf->Cell(60, 7, utf8_decode($seances[$billet->seance]), 0, 1, 'L', true);

			// Affichage Prénom Nom
			$pdf->SetFont('Helvetica','B',18);
			$pdf->SetXY(10, $offsetDuo + 79);
			$pdf->Cell(50, 10, utf8_decode($pre_nom), 0, 1, 'L', true);

			// Affichage Tarif
			$tarif = utf8_decode( $tarifs[$billet->tarif] . " - " . round($prix[$billet->tarif]) ) .iconv("UTF-8", "CP1252", "€00");
			$pdf->SetFont('Helvetica','B',12);
			$pdf->SetXY(10, $offsetDuo + 87);
			$pdf->Cell(50, 10, $tarif, 0, 1, 'L', true);
			$pdf->SetFont('Helvetica','',10);
			$pdf->SetXY(10, $offsetDuo + 96);
			$pdf->Cell(50, 5, utf8_decode("Association N°53236661400016"), 0, 1, 'L', true);


			// Affichage Placement libre
			$pdf->SetFont('Helvetica','',18);
			$pdf->SetXY(10, $offsetDuo + 68);
			$pdf->Cell(50, 10, utf8_decode('Placement libre - N°'), 0, 1, 'L', true);

			// Affichage Numéro Billet
			$pdf->SetFont('Helvetica','B',20);
			$pdf->SetXY(68, $offsetDuo + 67.6);
			$pdf->Cell(23, 10, utf8_decode($id), 0, 1, 'L', true);

			// Génération QR Code
			$path = storage_path('qr/'.$billet->id.'.png');
			$qr = [
				'id' 		=> $billet->qr,
				'system'	=> 'comedmus',
				'username'	=> $mail
			];
			\QrCode::format('png')->margin(0)->size(200)->generate(json_encode($qr), $path);
			$pdf->Image($path, 145, $offsetDuo + 70, 50);
			
		}

		$filename = ($billets->count() > 1) ? "Billets_Comedmus_2017.pdf" : $filename;
		$output = $pdf->Output('I', utf8_decode($filename), true);

		// Envoie de la réponse pdf
		return \Response::make($ouput, 200)->header('Content-Type', 'application/pdf');
	}



}
