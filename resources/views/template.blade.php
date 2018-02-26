<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Billetterie de la Comédie Musicale UTC</title>

    <meta name="author" content="Comédie Musicale UTC">
    <meta name="description" content="La Comédie Musicale de l'UTC, édition 2017">
    <!-- 
    <meta property="og:image" content="todo">
    <meta name="thumbnail" content="todo">
	<link rel="icon" type="image/jpg" href="todo">
	<link rel="icon" type="image/svg" href="todo">
     -->
	<meta name="theme-color" content="#5DAECE">

	<!-- Bootstrap CSS -->
	{{-- <link rel="stylesheet" type="text/css" href="todo"> --}}
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	
</head>

<body>
	<!-- Menu -->
	<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
		<div class="container">
			<a class="navbar-brand" href="{{ route("home") }}">Billetterie - Admin</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="menu">
				<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
					<li class="nav-item">
						<a class="nav-link" href="{{route('admin')}}">Dashboard</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{route('admin.present')}}">Billets validés</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{route('admin.achetes')}}">Billets Achetés</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{route('admin.listAll')}}">Toutes les infos</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="{{route('home')}}">Retour à la billetterie</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('logout')}}">Se déconnecter</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Content -->
	<main id="content" style="padding-top: 70px;">
		@yield("content")
	</main>

	<!-- Footer -->
	{{-- 
	<footer class="footer p-0 dfixed-bottom">
		<div class="container text-center py-2">
			&copy; Tous droits reservés - La Comédie Musicale 2017
			<br>Crédits graphiques : Justine Patin
			<br>Crédits photographiques : Pics'Art (en particulier Charles Herlin et Clément Passot)
			<br>Animation du logo : Natan Danous
			<br>Site réalisé par Alexandre Brasseur
		</div>
	</footer>
	 --}}

	<!-- jQuery, Popper and Bootstrap -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

</body>
</html>
