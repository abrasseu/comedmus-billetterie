<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billet extends Model
{
	protected $fillable = [
		'qr', 'tarif', 'seance', 'prenom', 'nom', 'transaction_id', 'navette', 'present'
	];
	protected $hidden = [];

	// Relations
	// public function user() {
	// 	return $this->belongsTo('App\User');
	// }
	public function transaction() {
		return $this->belongsTo('App\Transaction');
	}


	// ========== SCOPES	========================================

	// Retourne tous les billets valides
	public function scopeValide($query) {
		return $query->whereHas('transaction', function ($q) {
			$q->where('etat', 'V');
		});
	}
	public function scopeNotCanceled($query) {
		return $query->whereHas('transaction', function ($q) {
			$q->where('etat', '<>', 'A');
		});
	}
	public function scopeNavettes($query) {
		return $query->where('seance', '1')->where('navette', 1);
	}


	// ========== FUNCTIONS	========================================

	// Récupère le nombre de billets achetés
	public static function getAchetes() {
		$billetsPris = Billet::valide()->get();
		$nbBilletsAchetes = [
			[
				"cotisant" 	=> $billetsPris->where("seance", 0)->where("tarif", "cotisant")->count(),
				"mineur"    => $billetsPris->where("seance", 0)->where("tarif", "mineur")->count(),
				"etudiant" 	=> $billetsPris->where("seance", 0)->where("tarif", "etudiant")->count(),
				"plein" 	=> $billetsPris->where("seance", 0)->where("tarif", "plein")->count(),
				"total" 	=> $billetsPris->where("seance", 0)->count()
			],
			[
				"cotisant" 	=> $billetsPris->where("seance", 1)->where("tarif", "cotisant")->count(),
				"mineur"    => $billetsPris->where("seance", 1)->where("tarif", "mineur")->count(),
				"etudiant" 	=> $billetsPris->where("seance", 1)->where("tarif", "etudiant")->count(),
				"plein" 	=> $billetsPris->where("seance", 1)->where("tarif", "plein")->count(),
				"total" 	=> $billetsPris->where("seance", 1)->count()
			],
			[
				"cotisant" 	=> $billetsPris->where("seance", 2)->where("tarif", "cotisant")->count(),
				"mineur"    => $billetsPris->where("seance", 2)->where("tarif", "mineur")->count(),
				"etudiant" 	=> $billetsPris->where("seance", 2)->where("tarif", "etudiant")->count(),
				"plein" 	=> $billetsPris->where("seance", 2)->where("tarif", "plein")->count(),
				"total" 	=> $billetsPris->where("seance", 2)->count()
			],
			"total" 	=> $billetsPris->count()
		];
		return $nbBilletsAchetes;
	}

	// Récupère le nombre de billets restants
	public static function getRestants() {
		$billetsPris = Billet::notCanceled()->select('seance')->get();
		$stock = config("billets.stock");
		$nbBilletsRestant = [
			$stock[0] - $billetsPris->where("seance", 0)->count(),
			$stock[1] - $billetsPris->where("seance", 1)->count(),
			$stock[2] - $billetsPris->where("seance", 2)->count()
		];
		$nbBilletsRestant["total"] = array_sum($nbBilletsRestant);
		return $nbBilletsRestant;
	}

	public static function getRestantsBySeance($seance) {
		$stock = config("billets.stock")[$seance];
		$billetsPris = Billet::where("seance", $seance)->count();
		return $stock - $billetsPris;
	}
}
