<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Comédie Musicale UTC 2017</title>

	<meta name="author" content="Comédie Musicale UTC">
	<meta name="description" content="La Comédie Musicale de l'UTC, édition 2017">
	<meta property="og:image" content="{{ asset('img/logo/LogoBichrome.jpg') }}">
	<meta name="thumbnail" content="{{ asset('img/logo/LogoTexteFullWhite.jpg') }}">
	<link rel="icon" type="image/jpg" href="{{ asset('img/logo/LogoBichrome.jpg') }}">
	<link rel="icon" type="image/svg" href="{{ asset('img/logo/LogoBichrome.svg') }}">
	<meta name="theme-color" content="#5DAECE">

	{{-- Bootstrap CSS --}}
	<link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/all.min.css') }}">
		
	
	<script async src='https://www.googletagmanager.com/gtag/js?id=UA-107670544-1'></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-107670544-1');
	</script>
	
</head>

<body>
	{{-- Menu --}}
	<nav id="header" class="navbar fixed-top navbar-light navbar-toggleable-sm bg-white" role="navigation">
		<div class="container text-center my-auto">
			<div class="mb-2 mb-sm-0">
				<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#menu" aria-expanded="false" aria-controls="menu" aria-label="Afficher le menu" style="z-index: 1500; right: 0;">
					<span class="sr-only">Menu</span>
					<span class="navbar-toggler-icon"></span>
				</button>
				<a class="navbar-brand py-0" href="{{ route("home") }}">
					<img src="{{ asset('img/logo/LogoTexteFull.svg') }}" alt="Accueil" style="max-height:45px; width:100%; transform: translateX(-10%);">
					{{-- <span class="d-inline-block" style="border-left: 1px solid #555;">Billetterie</span> --}}
				</a>
			</div>

			<div id="menu" class="navbar-collapse collapse navbar-right">   
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a href="{{ route('select') }}" class="nav-link disabled{{ Route::currentRouteName()=='select' ? ' active' : '' }}">
						Acheter mes billets</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle{{ (Route::currentRouteName()=='account' || Route::currentRouteName()=='show') ? ' active' : '' }}" href="{{ route('account') }}" id="dropMonCompte" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mon Compte</a>
						<div class="dropdown-menu" aria-labelledby="dropMonCompte">
						@if (Auth::check())
							<a class="dropdown-item" href="{{ route('account') }}">Mes informations</a>
							<a class="dropdown-item" href="{{ route('show') }}">Mes billets</a>
							<a class="dropdown-item" href="{{ route('validationTransaction') }}">Mes commandes</a>
							<a class="dropdown-item" href="{{ route('logout') }}">Se déconnecter</a>
						@else
							<a class="dropdown-item" href="{{ route('login') }}">Se connecter</a>
						@endif
						</div>
					</li>


					<li class="nav-item">
						<a href="https://assos.utc.fr/comedmus/2017/contact/" class="nav-link">Contact</a>
					</li>
					<li class="nav-item">
						<a href="{{ route('home') }}" class="nav-link btn btn-primary text-white my-1 my-md-0 mx-md-1">Billetterie</a>
					</li>
					<li class="nav-item">
						<a href="https://assos.utc.fr/comedmus/2017/" class="nav-link btn btn-outline-secondary my-1 my-md-0 ml-md-1">Retourner au site</a>
					</li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>


	@yield('content')


	{{-- Footer --}}
	<footer class="footer p-0">
		<div class="container text-center py-2">
			&copy; Tous droits reservés - La Comédie Musicale 2017
			<br><a href="{{ route('cgv') }}" title="Lire les CGV">Conditions Générales de Ventes</a>
			<br>Crédits graphiques : Justine Patin
			<br>Crédits photographiques : Pics'Art (en particulier Charles Herlin et Clément Passot)
			<br>Animation du logo : Natan Danous
			<br>Site réalisé par Alexandre Brasseur
		</div>
	</footer>

	{{-- jQuery, Popper and Bootstrap --}}
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

	@yield('script')

</body>
</html>