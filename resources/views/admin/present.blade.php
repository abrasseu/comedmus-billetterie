@extends("template")

@section("content")

	<div class="container my-4">
		<h1 class="my-4">Billets présents
			<a class="btn btn-lg btn-primary float-md-right mt-4 mt-md-1 m-1" href="{{ route('admin.validateForce') }}" target="_blank">Valider un billet</a>
			<a class="btn btn-lg btn-success float-md-right mt-4 mt-md-1 m-1" href="{{ url()->current() }}">Mettre à jour</a>
		</h1>
		<hr class="my-4">

		<div class="row">
			<div class="col-12 col-md-4 my-4">
				<h4 class="text-center">Jeudi 14 Décembre</h4>
				<hr>
				<p class="lead text-center">
					<span class="font-weight-bold">{{ $billets->where('present', 1)->where('seance', 0)->count() }}</span>
					présents / {{ $billets->where('seance', 0)->count() }}
				</p>
				<p class="text-center"><a data-toggle="collapse" href="#allJeudi" aria-expanded="false" aria-controls="allJeudi">
					Voir les billets
				</a></p>
				<div class="collapse" id="allJeudi">
					<ul class="list-group">
						@foreach ($billets->where('seance', 0) as $billet)
							<li class="list-group-item{{ $billet->present ? ' list-group-item-success' : ''}}">
								{{ $billet->id ." - ".$billet->prenom." ".$billet->nom }}
							</li>
						@endforeach
					</ul>
				</div>
			</div>

			<div class="col-12 col-md-4 my-4">
				<h4 class="text-center">Vendredi 15 Décembre</h4>
				<hr>
				<p class="lead text-center">
					<span class="font-weight-bold">{{ $billets->where('present', 1)->where('seance', 1)->count() }}</span>
					présents / {{ $billets->where('seance', 1)->count() }}
				</p>
				<p class="text-center"><a data-toggle="collapse" href="#allVendredi" aria-expanded="false" aria-controls="allVendredi">
					Voir les billets
				</a></p>
				<div class="collapse" id="allVendredi">
					<ul class="list-group">
						@foreach ($billets->where('seance', 1) as $billet)
							<li class="list-group-item{{ $billet->present ? ' list-group-item-success' : ''}}">
								{{ $billet->id." - ".$billet->prenom." ".$billet->nom }}
							</li>
						@endforeach
					</ul>
				</div>
			</div>

			<div class="col-12 col-md-4 my-4">
				<h4 class="text-center">Samedi 16 Décembre</h4>
				<hr>
				<p class="lead text-center">
					<span class="font-weight-bold">{{ $billets->where('present', 1)->where('seance', 2)->count() }}</span>
					présents / {{ $billets->where('seance', 2)->count() }}
				</p>
				<p class="text-center"><a data-toggle="collapse" href="#allSamedi" aria-expanded="false" aria-controls="allSamedi">
					Voir les billets
				</a></p>
				<div class="collapse" id="allSamedi">
					<ul class="list-group">
						@foreach ($billets->where('seance', 2) as $billet)
							<li class="list-group-item{{ $billet->present ? ' list-group-item-success' : ''}}">
								{{ $billet->id." - ".$billet->prenom." ".$billet->nom }}
							</li>
						@endforeach
					</ul>
				</div>
			</div>

		</div>


	</div>

@endsection