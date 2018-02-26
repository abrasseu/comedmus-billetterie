@extends("template")

@section("content")

	<div class="container my-4">
		<h1 class="my-4">Toutes les infos</h1>
	</div>
	<div class="container-fluid mt-5">
		<table class="table table-responsive table-hover">
			<thead>
				<tr>
					<th id="users" class="text-center" colspan="3">USERS</th>
					<th id="transactions" class="text-center" colspan="4">TRANSACTIONS</th>
					<th id="billets" class="text-center" colspan="4">BILLETS</th>
				</tr>
				<tr>
					<th headers="users">ID</th>
					<th headers="users">Nom</th>
					<th headers="users">Mail</th>

					<th headers="transactions">ID</th>
					<th headers="transactions">Etat</th>
					<th headers="transactions">Création</th>
					<th headers="transactions">Modification</th>

					<th headers="billets">ID</th>
					<th headers="billets">Tarif</th>
					<th headers="billets">Séance</th>
					<th headers="billets">Personne</th>
				</tr>
			</thead>
			<tbody>
			{{-- USERS --}}
			@foreach ($users as $user)
				@php
					$userBilletCount = $user->billets()->count();
				@endphp
				<tr>
					<td rowspan="{{ $userBilletCount > 0 ? $userBilletCount : 1 }}">{{ $user->id }}</td>
					<td rowspan="{{ $userBilletCount > 0 ? $userBilletCount : 1 }}">{{ $user->prenom . ' ' . $user->nom }}</td>
					<td rowspan="{{ $userBilletCount > 0 ? $userBilletCount : 1 }}">{{ $user->email }}</td>
				{{-- TRANSACTIONS --}}
				@foreach ($user->transactions as $trans)
					@php
						$transBilletCount = $trans->billets()->count();
						$classEtat = '';
						switch ($trans->etat) {
							case 'V': $classEtat = 'table-success'; break;
							case 'W': $classEtat = 'table-warning'; break;
							case 'A': $classEtat = 'table-danger'; 	break;
						}
					@endphp
					{!! $loop->first ? '' : '<tr>' !!}
						<td rowspan="{{ $transBilletCount }}" class="{{ $classEtat }}">{{ $trans->id }}</td>
						<td rowspan="{{ $transBilletCount }}" class="{{ $classEtat }}">{{ $trans->etat }}</td>
						<td rowspan="{{ $transBilletCount }}" class="{{ $classEtat }}">{{ $trans->created_at }}</td>
						<td rowspan="{{ $transBilletCount }}" class="{{ $classEtat }}">{{ $trans->updated_at }}</td>
					{{-- BILLETS --}}
					@foreach ($trans->billets as $billet)
						{!! $loop->first ? '' : '<tr>' !!}
							<td class="{{ $classEtat }}">{{ $billet->id }}</td>
							<td class="{{ $classEtat }}">{{ $tarifsName[$billet->tarif] }}{{ ($billet->navette) ? ' (Navette)' : ''}}</td>
							<td class="{{ $classEtat }}">{{ $seancesName[$billet->seance] }}</td>
							<td class="{{ $classEtat }}">{{ $billet->prenom . " " . $billet->nom }}</td>
						</tr>
					@endforeach
				@endforeach
			@endforeach
			</tbody>
		</table>
	</div>

@endsection