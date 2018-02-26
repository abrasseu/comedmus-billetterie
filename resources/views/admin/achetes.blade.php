@extends("template")

@php
	$papiers = [
		// Jeudi
		  2 	// Brulerie	
		+ 2 	// Cauette		
		+ 1 	// Gala			
		+ 9 	// Amicale
		+ 1 	// Arielle Francois
		+ 2 	// Ventes Librairie des signes
		+ 8 	// Ventes marché
		+ 4 	// Ventes BF
		,
		// Vendredi
		  4		// Ventes marché
		+ 5		// Ventes BF
		+ 1		// Olivier Gapenne
		+ 16	// Amicale
		+ 2		// Stéphanie & Frédéric Huglo
		+ 1		// Pro musique
		+ 1		// Hédou?
		+ 1		// Concours FB utceene
		,
		// Samedi
		1		// Pro danse
		+ 2		// Epoux Morizet-Mahoudeaux
		+ 1 	// Arielle Francois
		+ 15	// Amicale
		+ 10	// Ventes marché
		+ 0		// Ventes BF
		,
		// Inconnu
		  2		// Librairie des signes
		+ 2		// Société Générale
		+ 1		// Pro mise en scène
		+ 1		// Pro écriture
	];
@endphp

@section("content")

	<div class="container my-4">
		<h1 class="my-4">Billets achetés</h1>
		<hr class="my-4">
		<p class="lead"><span class="font-weight-bold">{{$nbBilletsAchetes["total"]}}</span> billets ont été <span class="font-weight-bold">achetés sur la billetterie</span>
		<p class="lead"><span class="font-weight-bold">{{ array_sum($papiers) }}</span> billets ont été <span class="font-weight-bold">achetés en version papier</span>
		</p>
		<p class="lead"><span class="font-weight-bold">{{$navettes}}</span> personnes prennent une <span class="font-weight-bold">navette</span></p>

		<table class="table table-responsive mt-4">
			<thead>
				<tr>
					<th>Tarif</th>
					<th>Jeudi 14 Décembre</th>
					<th>Vendredi 15 Décembre</th>
					<th>Samedi 16 Décembre</th>
					<th>Estimation</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($tarifsArr as $tarif)
				<tr>
					<th>{{ $tarifsName[$tarif] }}</th>
					<td>{{ $nbBilletsAchetes[0][$tarif] }}</td>
					<td>{{ $nbBilletsAchetes[1][$tarif] }}</td>
					<td>{{ $nbBilletsAchetes[2][$tarif] }}</td>
					<td>{{ $somme[$tarif] }} €</td>
				</tr>
				@endforeach
				<tr>
					<th>Total</th>
					<td>{{ $nbBilletsAchetes[0]["total"] }}/{{ $stock[0] }}</td>
					<td>{{ $nbBilletsAchetes[1]["total"] }}/{{ $stock[1] }}</td>
					<td>{{ $nbBilletsAchetes[2]["total"] }}/{{ $stock[2] }}</td>
					<td class="font-weight-bold">{{ $somme["total"] }} €</td>
				</tr>
				<tr>
					<th>Billets papiers</th>
					<td>{{ $papiers[0] }}</td>
					<td>{{ $papiers[1] }}</td>
					<td>{{ $papiers[2] }}</td>
					<td class="font-weight-bold">{{ $papiers[3] }} date inconnu</td>
				</tr>
				<tr>
					<th>Restants (sans compter papiers)</th>
					<td>{{ $nbBilletsRestant[0] }}/{{ $stock[0] }}</td>
					<td>{{ $nbBilletsRestant[1] }}/{{ $stock[1] }}</td>
					<td>{{ $nbBilletsRestant[2] }}/{{ $stock[2] }}</td>
					<td>{{ $nbBilletsRestant["total"] }}</td>
				</tr>
			</tbody>
		</table>
	</div>

@endsection