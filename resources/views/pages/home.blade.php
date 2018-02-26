@extends('pages.template')
@section('content')

<main id="content">
<section class="slide bg-parchemin d-flex flex-column justify-content-center">
	<div class="container bg-transparent rounded p-3 p-md-5" style="max-width: 800px;">
		<h1 class="text-center">Bienvenue sur la billetterie de la Com'</h1>
		<hr class="mb-4">
		<div class="d-flex justify-content-around flex-wrap">
			<a class="col-12 col-md-5 btn btn-lg btn-primary m-1 disabled" href="{{ route('select') }}" title="Acheter un billet">Acheter des billets</a>
			<a class="col-12 col-md-5 align-items-start 	btn btn-lg btn-primary m-1" href="{{ route('show') }}" title="Voir mes billets">Voir mes billets</a>
		</div>
		<p class="text-center lead mt-4">Toutes les places pour le samedi ont été vendues ! Merci beaucoup !</p>
		<p class="text-center mb-0 mt-5">
			<a class="lead" href="https://assos.utc.fr/comedmus/2017/" title="Voir mes billets">Retourner sur le site</a>
		</p>
	</div>
</section>
</main>

@endsection