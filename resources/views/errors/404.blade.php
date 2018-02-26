@extends('pages.template')
@section('content')

<main id="content">
<section class="slide bg-parchemin d-flex flex-column justify-content-center">
	<div class="container bg-transparent rounded p-3 p-md-5" style="max-width: 800px;">
		<h1 class="text-center">La page n'existe pas !</h1>
		<hr class="mb-4">
		<p>
			Cette page n'existe pas, retrouvez votre chemin en <a href="{{ route('home') }}" title="Aller à l'accueil">retournant à l'accueil de la billetterie</a>.
		</p>

	</div>
</section>
</main>

@endsection