<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'prenom', 'nom', 'email', 'password', 'login', 'unsubscribed'
    ];
    protected $hidden = [
        'password', 'remember_token'
    ];

    // Relations
    public function billets() {
        return $this->hasManyThrough('App\Billet', 'App\Transaction');
    }
    public function transactions() {
        return $this->hasMany('App\Transaction');
    }

    public function scopeNews($query) {
        return $query->where('news', true);
    }

}
