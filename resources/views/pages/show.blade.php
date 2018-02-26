@extends('pages.template')
@section('content')

<main id="content">
<section class="slide bg-parchemin d-flex flex-column justify-content-center">
	<div class="container bg-transparent rounded p-4">
		<h3 class="text-center">Vos billets</h3>
		<hr>

		{{-- Erreurs --}}
		@if ($errors->any())
			<div class="alert alert-danger">
				<ul class="pl-2">
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		@if ($billets->isEmpty())
			<p class="text-center">
				Vous n'avez aucun billet, achetez en <a href="{{ route('select') }}" title="Acheter des billets">ici</a>.
			</p>

		@else
			<p class="text-center mb-4">
				<a class="btn btn-primary m-1" href="{{ route('generateAll') }}" target="_blank" title="Télécharger tous mes billets">Télécharger tous mes billets</a>
				<a class="btn btn-primary m-1" href="{{ route('select') }}" title="Acheter d'autres billets">Acheter d'autres billets</a>
			</p>

			<div class="row">
			@foreach ($billets as $billet)
				<div class="col-sm-6 col-lg-4">
					<div class="card card-outline-primary mb-3">
						<div class="card-header bg-white"><h4 class="m-0">Billet {{ $billet->id }}</h4></div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item">
								<span class="font-weight-bold pr-1">Séance :</span>{{ $seances[$billet->seance] }}
							</li>
							<li class="list-group-item">
								<span class="font-weight-bold pr-1">Tarif :</span>{{ $tarifs[$billet->tarif] }}
							</li>
							<li class="list-group-item">
								<span class="font-weight-bold pr-1">Prénom :</span><span id="prenom-{{$billet->id}}">{{ $billet->prenom }}</span>
							</li>
							<li class="list-group-item">
								<span class="font-weight-bold pr-1">Nom :</span><span id="nom-{{$billet->id}}">{{ $billet->nom }}</span>
							</li>
							@if ( ($billet->tarif == 'etudiant' || $billet->tarif == 'cotisant') && $billet->seance == "1")
							<li class="list-group-item">
								<span class="font-weight-bold pr-1">Navette (Paris-Compiègne) :</span><span id="nav-{{$billet->id}}" data-nav="{{$billet->navette}}">{{ $billet->navette ? 'Oui' : 'Non' }}</span>
							</li>
							@endif
						</ul>
						<div class="card-footer p-0">
							<div class="row">
								<div class="col-md-6">
									<a class="btn btn-link btn-block text-center" onclick="modify({{ $billet->id }})" title="Télécharger ce billet" data-toggle="modal" data-target="#modify">Modifier</a>
								</div>
								<div class="col-md-6">
									<a class="btn btn-link btn-block text-center" target="_blank" href="{{ route('generate', ['billet_id' => $billet->id]) }}" title="Télécharger ce billet">Télécharger</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
			</div>
		@endif

	</div>
</section>
</main>

@endsection


{{-- Modal --}}
<div class="modal fade" id="modify" tabindex="-1" role="dialog" aria-labelledby="modifyLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modifyLabel">Modifier le billet <span id="m-billet-id"></span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<form action="{{ route('modify')}}" method="POST" accept-charset="utf-8">
			{{ csrf_field() }}
			<div class="modal-body">
				<input type="hidden" id="m-id" name="id" value="">
				<div class="row">
					<fieldset class="form-group col-md-6">
						<label for="m-prenom" class="form-control-label">Prénom :</label>
						<input id="m-prenom" type="text" class="form-control" name="prenom" placeholder="Prénom" required>
					</fieldset>
					<fieldset class="form-group col-md-6">
						<label for="m-nom" class="form-control-label">Nom :</label>
						<input id="m-nom" type="text" class="form-control" name="nom" placeholder="Nom" required>
					</fieldset>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
				<input type="submit" class="btn btn-primary" value="Modifier">
			</div>
			</form>
		</div>
	</div>
</div>



@section('script')

<script type="text/javascript" charset="utf-8" defer>
	var on = false;
	function modify(id) {
		$("#m-billet-id").text(id);
		$("#m-id").val(id);
		$("#m-prenom").val($("#prenom-"+id).text());
		$("#m-nom").val($("#nom-"+id).text());

		// Si navette et pas déjà mis
		if ( $("#nav-"+id).length && !on ) {
			$(".modal-body").append('<fieldset id="f-nav" class="form-group"><label for="m-navette" class="form-check-label"><input class="form-check-input" type="radio" name="navette" value="1" ' + ($("#nav-"+id).data('nav') == "1" ? "checked" : "") + '>Je veux une navette</label><br><label for="m-navette" class="form-check-label"><input class="form-check-input" type="radio" name="navette" value="0" ' + ($("#nav-"+id).data('nav') == "0" ? "checked" : "") + '>Je n\'ai pas besoin de navette</label></fieldset>');
			on = true;
		}

		// Si pas de navettes
		if ( !$("#nav-"+id).length ) {
			$("#f-nav").remove();
			on = false;
		}
	}

</script>

@endsection