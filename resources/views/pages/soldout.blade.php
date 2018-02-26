@extends('pages.template')
@section('content')

<main id="content">
<section class="slide bg-parchemin d-flex flex-column justify-content-center">
	<div class="container bg-transparent rounded p-3 p-md-5" style="max-width: 800px;">
		<h1 class="text-center">Merci beaucoup !</h1>
		<hr class="mb-4">
		<div class="d-flex justify-content-center flex-wrap">
			<p class="lead">Toutes les places pour le samedi ont été vendues !</p>
		</div>
		{{-- <hr class=""> --}}
		<p class="text-center mb-0 mt-5">
			<a class="lead m-2 mx-4" href="{{ route('show') }}" title="Voir mes billets">Voir mes billets</a>
			<a class="lead m-2 mx-4" href="https://assos.utc.fr/comedmus/2017/" title="Retourner sur le site">Retourner sur le site</a>
		</p>
	</div>
</section>
</main>

@endsection