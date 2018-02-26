@extends('pages.template')
@section('content')

<main id="content" >
	<section class="slide bg-parchemin">        
		<!-- Formulaire -->
		<div class="bg-transparent rounded p-4 mx-auto" style="max-width: 700px;">
			<h1 class="text-center">Acheter des billets</h1>
			<hr class="mb-4">
			<h3 class="mb-3">Veuillez rentrer vos informations : </h3>
			<form action="{{ route('selectPost') }}" method="POST">
				{{ csrf_field() }}

				{{-- Erreurs --}}
				@if ($errors->any())
					<div class="alert alert-danger">
						<ul class="pl-2">
							@foreach ($errors->all() as $error)
								<li>{!! $error !!}</li>
							@endforeach
						</ul>
					</div>
				@endif

				{{-- Déjà connecté --}}
				@if (Auth::check())
					@php
						$user = Auth::user();
					@endphp
					<p>
						Connecté en tant que <span class="font-weight-bold">{{ $user->prenom.' '.$user->nom }}</span> (<span class="font-italic">{{ $user->email }}</span>).
						<br>
						<a href="{{ route('logout')}}" title="Se déconnecter">Se déconnecter</a>
					</p>
					<input type="hidden" name="connected" value="1">
					<p>
						@if (session()->has('login'))
							Vous êtes connecté au CAS de l'UTC. Vous pouvez acheter un billet cotisant maximum.
						@else
							Pour acheter un billet cotisant, veuillez vous <a href="{{ config("billets.cas.login").route('loginCas') }}">connectez au CAS de l'UTC</a> avant de commander.						
						@endif
					</p>					

				{{-- Choix connexion --}}
				@else
					<p>
						@if (session()->has('login'))
							Vous êtes connecté au CAS de l'UTC. Vous pouvez acheter un billet cotisant maximum.
						@else
							Pour acheter un billet cotisant, veuillez vous <a href="{{ config("billets.cas.login").route('loginCas') }}">connectez au CAS de l'UTC</a> avant de commander.						
						@endif
					</p>					

					<div class="row my-2 px-md-3">
						<div class="col-md-6">
							<label class="form-check-label">
								<input class="form-check-input" onchange="changeClient(true)" type="radio" name="new-client" value="1" checked>
								Nouveau client</label>
						</div>
						<div class="col-md-6">
							<label class="form-check-label "">
								<input class="form-check-input" onchange="changeClient(false)" type="radio" name="new-client" value="0">
								J'ai déjà réalisé un achat</label>
						</div>
					</div>	
					<hr>

					{{-- Compte client --}}
					<div id="client">
						<div class="row onlyNewClient">
							<fieldset class="form-group col-md-6">
								<label for="client-prenom" class="form-control-label">Prénom :</label>
								<input id="client-prenom" type="text" class="form-control" name="client-prenom" placeholder="Prénom" 
										value="{{ session()->has('prenom') ? session('prenom') : old('client-prenom') }}" required>
							</fieldset>
							<fieldset class="form-group col-md-6">
								<label for="client-nom" class="form-control-label">Nom :</label>
								<input id="client-nom" type="text" class="form-control" name="client-nom" placeholder="Nom" 
										value="{{ session()->has('nom') ? session('nom') : old('client-nom') }}" required>
							</fieldset>
						</div>
						<div class="row">
							<fieldset class="form-group col-md-6">
								<label for="email" class="form-control-label">Email :</label>
								<input id="mail" type="email" class="form-control" name="email" placeholder="jean.dujardin@email.fr" required value="{{ session()->has('email') ? session('email') : old('email')}}">
							</fieldset>
							<fieldset class="form-group col-md-6">
								<label id="label-password" for="password" class="form-control-label">Créer un Mot de passe :</label>
								<input id="password" type="password" class="form-control" name="password" required>
							</fieldset>
						</div>
					</div>
				@endif

				{{-- Billets --}}
				<div id="form-billet"></div>
				<br>
				<div class="d-flex justify-content-end flex-wrap">				
					<button id="form-add" type="button" class="col-12 col-sm-4 btn btn-secondary m-2">Ajouter un billet</button>
					<button id="form-buy" type="button" class="col-12 col-sm-4 btn btn-primary m-2" data-toggle="modal" data-target="#confirmationModal">Acheter</button>
				</div>

				{{-- Modal --}}
				<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
					<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="confirmation">Confirmation d'achat</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
						</div>
						<div class="modal-body">
							<p class="text-justify">
								Vos billets sont réservés pendant 15 minutes après la confirmation de l'achat, passé ce temps la transaction est annulée.
								<br>En achetant ces billets vous consentez à respecter nos <a href="{{route('cgv')}}" target="" title="Lire nos Conditions Générales de Vente">Conditions Générales de Vente</a>.
						</div>
						<div class="modal-footer px-2">
							<div class="col-sm-6 mx-0 my-1">
								<button class="btn btn-block btn-secondary" type="button" data-dismiss="modal">Revoir ma commande</button>
							</div>
							<div class="col-sm-6 mx-0 my-1">
								<input id="submitForm" class="btn btn-block btn-primary" type="submit" value="Confirmer l'achat">
							</div>
					</div>
					</div>
				</div>

			</form>
		</div>

	</section>
</main>

@endsection


	


@section('script')

<script type="text/javascript">
$( document ).ready(function() {

	function addBillet() {
		billetCounter++;
		$('#form-billet').append('@include("pages._billet_add_min")');
	}
	var billetCounter = 0;

	// Récupération des infos ou nouveau billet
	var oldBillets = {!! old('billet') ? json_encode(array_values(old('billet')), JSON_NUMERIC_CHECK ) : 'null' !!};
	if(oldBillets)
		oldBillets.forEach(function(billet) {
			addBillet();
			$("select[name='billet["+billetCounter+"][seance]'] option[value='"+billet.seance+"']").prop('selected', true);
			$("select[name='billet["+billetCounter+"][tarif]'] 	option[value='"+billet.tarif+"']" ).prop('selected', true);
			$("input[name='billet["+billetCounter+"][prenom]']").val(billet.prenom);
			$("input[name='billet["+billetCounter+"][nom]']").val(billet.nom);
		});
	else
		addBillet();

	// Ajout de billet
	$('#form-add').click(function() {
		addBillet();
	});

	// Retrait de billet
	$('#form-billet').on('click', '.billet-remove', function() {
		$(this).closest(".billet").remove();
		billetCounter--;
	});

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});

});
var onlyNewClientDiv = $('.onlyNewClient');

function changeClient(nouveau) {
	if (nouveau) {
		$('#client').prepend(onlyNewClientDiv);
		$('#label-password').text('Créer un Mot de passe :');
	} else {
		$(".onlyNewClient").remove();
		$('#label-password').text('Votre Mot de passe :');
	}
};
</script>

@endsection