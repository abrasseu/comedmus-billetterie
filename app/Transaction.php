<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $fillable = [
		'id', 'etat', 'user_id'
	];
	protected $hidden = [];

	// Relations
	public function user() {
		return $this->belongsTo('App\User');
	}
	public function billets() {
		return $this->hasMany('App\Billet');
	}

	// ========== SCOPES	========================================

	public function scopeValide($query) {
		return $query->where('etat', 'V');
	}

	// Si les transactions ont été créées plus de 15min avant maintenant
	public function scopeOutdated($query) {
		return $query->where('etat', 'W')->where('created_at', '<', \Carbon\Carbon::now()->subMinutes(15)->setTimezone('UTC')->toDateTimeString());
	}

	// ========== FUNCTIONS	========================================


}
