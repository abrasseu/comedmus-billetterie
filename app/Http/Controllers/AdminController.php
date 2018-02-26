<?php

namespace App\Http\Controllers;

use App\User;
use App\Billet;
use App\Transaction;
use App\Payutc\Payutc;
use Illuminate\Http\Request;
use App\Http\Requests\InfosAchat;
use App\Notifications\BilletAvailable;
use App\Mail\Merci;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
	public function dashboard()
	{
		return view('admin.dashboard');
	}

	// Compte les billets présents
	public function present()
	{
		$billets = Billet::valide()->get()->sortBy('present');	
		return view('admin.present', compact('billets'));
	}

	// Lister tous les billets
	public function listAll()
	{
		$users = User::with(['transactions', 'billets'])->get();
		$seancesName = config("billets.seances");
		$tarifsName = config("billets.tarifs");
		return view('admin.listAll', compact('users', 'seancesName', 'tarifsName'));
	}

	// Table tous les billets
	public function tableAchat()
	{
		$nbBilletsAchetes = Billet::getAchetes();
		$nbBilletsRestant = Billet::getRestants();
		
		$stock = config("billets.stock");
		$prix = config("billets.prix");
		$tarifsArr = config("billets.tarifsArr");
		$tarifsName = config("billets.tarifs");

		$navettes = Billet::navettes()->count();
		
		$somme = [];
		$somme["total"] = 0;
		foreach ($tarifsArr as $tarif) {
			$somme[$tarif] = $prix[$tarif] * ($nbBilletsAchetes[0][$tarif] + $nbBilletsAchetes[1][$tarif] + $nbBilletsAchetes[2][$tarif]);
			$somme["total"] += $somme[$tarif];
		}
		return view('admin.achetes', compact('nbBilletsAchetes', 'nbBilletsRestant', 'stock', 'somme', 'tarifsName', 'tarifsArr', 'navettes'));
	}

	public function generate($id) {
		$billets = Billet::where('id', $id)->get();
		$mail = $billets->first()->transaction()->first()->user()->first()->email;
		return \App\Http\Controllers\BilletController::generatePDF($billets, $mail);
	}

	public function notifyAll() {
		return "1167 mails already sent";		// Blocked

		$clients = User::whereHas('transactions', function ($query) {
			$query->where('etat', 'V');
		})->get();

		$nbMails = 0;
		foreach ($clients as $client) {
			$etu = preg_match('/@etu\.utc\.fr$/', $client->email);
			\Mail::to($client)->send(new Merci($client->email, $etu));
			$nbMails++;
			if ($nbMails > 0) dd($nbMails);
		}
		return $nbMails . " mails sent";
	}


}
