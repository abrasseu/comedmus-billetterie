@extends('pages.template')
@section('content')

<main id="content">
<section class="slide bg-parchemin d-flex flex-column justify-content-center">
	<div class="container bg-transparent rounded p-4" style="max-width: 600px;">
		<h3 class="">Newsletter</h3>
		<hr>
		<p class="lead">
			Vous êtes {{ $message }}.		
		</p>
		@if ($resubscribe)
			<a class="btn btn-outline-success d-inline-block mx-auto my-2" href="{{ route('subscribe') }}" 
				title="Vous réinscrire">Se réinscrire</a>
		@else
			<a class="btn btn-outline-warning d-inline-block mx-auto my-2" href="{{ route('unsubscribe') }}" 
				title="Vous réinscrire">Se désinscrire</a>
		@endif
	</div>
</section>
</main>

@endsection

