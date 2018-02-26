<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}

	public function subscribe() {
		$user = \Auth::user();

		if ($user->news == true) {
			$message = 'déjà inscrit';
		} else {
			$user->news = true;
			$user->save();
			$message = 'inscrit';
		}

		$resubscribe = false;
		$mail = $user->email;
		return view('pages.subscribtion', compact('mail', 'message', 'resubscribe'));
	}

	public function unsubscribe() {
		$user = \Auth::user();

		if ($user->news == false) {
			$message = 'déjà désinscrit';
		} else {
			$user->news = false;
			$user->save();
			$message = 'désinscrit';
		}

		$resubscribe = true;
		$mail = $user->email;
		return view('pages.subscribtion', compact('mail', 'message', 'resubscribe'));
	}

}
