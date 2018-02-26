<?php

namespace App\Http\Middleware;

use Closure;
use App\CAS;
use App\Payutc\Payutc;
use App\Ginger\GingerClient as Ginger;

class CheckAdmin
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// Si l'utilisateur n'a pas déjà été connecté, on passe par login CAS
		if (!session()->has('login'))
			return redirect()->route('loginCas', ['redirRoute' => 'admin']);

		// Vérification admin
		$admins = \DB::select('SELECT * FROM admins WHERE login = ?', [session('login')]);

		if (empty($admins))
			return redirect()->route('home');	// Redirection vers l'accueil si pas autorisé
		else
			return $next($request);				// Sinon ok
	}








}
