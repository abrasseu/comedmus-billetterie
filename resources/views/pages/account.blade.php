@extends('pages.template')
@section('content')

<main id="content">
<section class="slide bg-parchemin d-flex flex-column justify-content-center">
	<div class="container bg-transparent rounded p-3 p-md-5" style="max-width: 850px;">
		<h1 class="text-center">Mon Compte</h1>
		<hr class="mb-4">
		<div class="row align-items-center">
			<div class="col-md-6">
				<table class="table table-responsive">
					<thead>
						<tr>
							<th colspan="2">Vos informations</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Prénom</th>
							<td>{{ $user->prenom }}</td>
						</tr>
						<tr>
							<th>Nom</th>
							<td>{{ $user->nom }}</td>
						</tr>
						<tr>
							<th>Mail</th>
							<td>{{ $user->email }}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-6">
				<div class="d-flex flex-column h-100 align-content-around">
					<a class="btn btn-primary m-1" href="{{ route('show') }}" title="Voir mes billets">Voir mes billets</a>
					<a class="btn btn-primary m-1" href="{{ route('select') }}" title="Acheter des billets">Acheter des billets</a>
					<a class="btn btn-primary m-1" href="{{ route('validationTransaction') }}" title="Voir mes commandes">Voir mes commandes</a>
					@if(Auth::user()->news == true)
						<a class="btn btn-primary m-1" href="{{ route('subscribe') }}" title="M'inscrire de la Newsletter">M'inscrire à la Newsletter</a>
					@else
						<a class="btn btn-primary m-1" href="{{ route('unsubscribe') }}" title="Me désinscrire de la Newsletter">Me désinscrire de la Newsletter</a>
					@endif
					<a class="btn btn-secondary m-1" href="{{ route('logout') }}" title="Se déconnecter">Se déconnecter</a>
				</div>
			</div>
		</div>
	</div>
</section>
</main>

@endsection