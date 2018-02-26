<?php

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
| Auth::routes();
*/

// Login/out
Route::get('login',  'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Password reset
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::get('password/reset',  'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::match(['get', 'head'], 'password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

// Register
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'Auth\RegisterController@register');




/*
|--------------------------------------------------------------------------
| Billetterie
|--------------------------------------------------------------------------
*/


// Accueil
Route::get('', 'BilletController@home')->name('home');

// Rentrer les infos
Route::get('choisir/', function() {
	return view('pages.soldout');
})->name('select');
// Route::get('choisir/', 'BilletController@select')->name('select');

// Achat du billet
Route::post('choisir/', 'BilletController@verifSelect')->name('selectPost');

// Login CAS pour tarif cotisant
Route::get('loginCas/{redirRoute?}', 'BilletController@loginCas')->name('loginCas');

// CGV
Route::get('conditions/', function() {
	return view('pages.cgv');
})->name('cgv');

// Besoin d'un utilisateur loggué
Route::middleware(['auth'])->group(function () {

	// (Dés)Inscription des mails
	Route::get('newsletter/inscription/', 'UserController@subscribe')->name('subscribe');
	Route::get('newsletter/desinscription/', 'UserController@unsubscribe')->name('unsubscribe');

	// ========== TRANSACTION 	==============================

	// Validation de la transaction
	Route::get('mescommandes', 'BilletController@validationTransaction')->name('validationTransaction');

	// Gestion des transactions
	Route::get('payer/{tra_id}/', 'BilletController@pay')
		->where('tra_id', '[0-9]+')
		->name('pay');
	Route::get('annuler/{tra_id}/', 'BilletController@cancel')
		->where('tra_id', '[0-9]+')
		->name('cancel');

	// ========== COMPTE 		==============================

	// Mon compte
	Route::get('moncompte/', function() {
		$user = Auth::user();
		return view('pages.account', compact('user'));
	})->name('account');


	// Affichage des billets
	Route::get('mesbillets/', 'BilletController@show')->name('show');
	Route::post('modifier/', 'BilletController@modify')->name('modify');

	// Génération des billets
	Route::get('mesbillets/generer/{billet_id}', 'BilletController@generate')
		->where('billet_id', '[0-9]+')
		->name('generate');
	Route::get('mesbillets/generer/', 'BilletController@generateAll')->name('generateAll');


});



/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['checkAdmin'])->prefix('admin/')->group(function() {

	// Accueil
	Route::get('', 'AdminController@dashboard')->name('admin');

	// Voir les places restantes
	Route::get('billetsAchetes/', 'AdminController@tableAchat')->name('admin.achetes');

	// Liste de tous les billets
	Route::get('present', 'AdminController@present')->name('admin.present');
	Route::get('liste', 'AdminController@listAll')->name('admin.listAll');

	// ATTENTION !! Spam tout le monde
	Route::get('notifyAll', 'AdminController@notifyAll')->name('admin.notifyAll');
	Route::get('listeNewsletter', function() {
		$users = App\User::whereHas('transactions', function ($query) {
			$query->where('etat', 'V');
		})->where('unsuscribed', false)->pluck('email')->toArray();;
		return json_encode($users);
	});

	// Génération de billet forcée
	Route::get('generate/{id}', 'AdminController@generate')->name('admin.generate');

	// Validation forcée
	Route::get('validate', function() {
		return view('admin.validate');
	})->name('a.validateForce');
	Route::post('validate', 'BilletController@validateForce')->name('admin.validateForce');

	Route::get('outdated', function() {
        $outdated = \App\Transaction::outdated()->get();
        foreach ($outdated as $trans) {
            $transPayutc = \App\Payutc\Payutc::checkTransaction($trans->id);

			if ($trans->etat == 'W' && $transPayutc->status == 'V')		// Transaction fraichement validée
				\Notification::send($trans->user()->first(), new \App\Notifications\BilletAchete($trans->id));
            $trans->etat = $transPayutc->status;    // Maj des état

            // Encore en attente
            // if ($trans->etat == 'W') {
            //     $data = Payutc::cancelTransaction($trans->id);          // Annulation de la transaction
            //     dd($data);
            // }

            $trans->save();
        }
        echo $outdated->count() . " outdated";
        return dd($outdated);
	});
	
	Route::get('navettes', function() {
		$navettes = \App\Billet::valide()->navettes()->get();
		return view('admin.navettes', compact('navettes'));
	});

	Route::get('news', function() {
		$list = \App\User::whereHas('transactions', function ($query) {
			$query->where('etat', 'V');
		})->news()->pluck('email')->toArray();
		return response()->json($list, 200);
	});

});



/*
|--------------------------------------------------------------------------
| Test
|--------------------------------------------------------------------------
*/
/**/
Route::middleware(['checkAdmin'])->prefix('test/')->group(function() {

	Route::get('mail', function() {
		$client = \Auth::user();
		\Notification::send($client, new \App\Notifications\Merci());

	});

	Route::get('outdated', function() {

		$outdated = \App\Transaction::where('etat', 'W')->get();
		$payutc = \App\Payutc\Payutc::createPayutc();
		foreach ($outdated as $trans) {
			// dd($trans);
			$transPayutc = $payutc->checkTransaction($trans->id);

			$trans->etat = $transPayutc->status;    // Maj des état
			if ($trans->etat == 'W') {
				$data = $payutc->cancelTransaction($trans->id);
				dd($data);
				// Annulation de la transaction
			}


			$trans->save();
		}

	});

});

/*
|--------------------------------------------------------------------------
|	QR Codes API
|--------------------------------------------------------------------------
*/

Route::get('qr/{key}/{hash}', 'BilletController@getQR');

Route::get('qr/{key}/{hash}/validate', 'BilletController@validateQR');

