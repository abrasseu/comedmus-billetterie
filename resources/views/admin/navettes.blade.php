@extends("template")

@section("content")

	<div class="container my-4">
		<h1 class="my-4">Informations sur les navettes</h1>
		<hr>
		<p class="lead"><span class="font-weight-bold">{{ $navettes->count() }} personnes</span> prennent la navette (rt si c pa bokou)</p>
		<table class="table table-responsive table-hover">
			<thead>
				<tr>
					<th>N°Billet</th>
					<th>Prénom</th>
					<th>Nom</th>
					<th>Mail</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($navettes as $billet)
				<tr>
					<td>{{ $billet->id }}</td>
					<td>{{ $billet->prenom }}</td>
					<td>{{ $billet->nom }}</td>
					<td>{{ $billet->transaction()->first()->user()->first()->email }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>

@endsection