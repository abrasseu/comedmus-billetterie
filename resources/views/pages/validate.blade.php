@extends('pages.template')
@section('content')

<main id="content">
<section class="slide bg-parchemin d-table">        
	<div class="d-table-cell align-middle"> 
	<div class="container">
			<div class="row justify-content-center">
			<div class="col-md-8">
			<div class="box">
				<h2>Vos commandes</h2>
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
				
				@if ($transactions->isEmpty())
					<p class="text-justify alert alert-info">
						Vous n'avez effectué aucune commande, si vous pensez que cela ne devrait pas être le cas merci d'envoyer un mail à {!! 'comedmus@gmail.com' !!}.
					</p>
				@else
					@foreach ($transactions as $trans)
						@switch($trans->etat)
							@case('V')
								<p class="text-justify alert alert-success">
									La commande <span class="font-weight-bold">{{ $trans->id }}</span> a été validée,
									vous pouvez télécharger vos billets <a href="{{ route('show') }}" title="Voir mes billets">ici</a>.
								</p>
								@break
							@case('W')
								<p class="text-justify alert alert-warning">
									La commande <span class="font-weight-bold">{{ $trans->id }}</span> est encore en attente de paiement,
									<a href="{{ route('pay', ['tra_id' => $trans->id]) }}" title="Voir mes billets">retourner à la transaction pour la payer</a>
									ou <a href="{{ route('cancel', ['tra_id' => $trans->id ]) }}" title="Annuler la transaction">annuler la</a>.
								</p>
								@break
							@case('A')
								<p class="text-justify alert alert-danger">
									La commande <span class="font-weight-bold">{{ $trans->id }}</span> a été annulée,
									vous pouvez relancer une autre commande <a href="{{ route('select') }}" title="Acheter des billets">ici</a>.
								</p>
								@break
							@default
								<p class="text-justify alert alert-danger">
									La commande <span class="font-weight-bold">{{ $trans->id }}</span> a eu une erreur,
									en cas de problème merci d'envoyer un mail à {!! 'comedmus@gmail.com' !!}.
								</p>
						@endswitch
					@endforeach
				@endif
				
				<hr>
				<p class="text-center">
					<a class="btn btn-primary m-1" href="{{ route('select') }}" title="Acheter d'autres billets">Acheter d'autres billets</a>
					<a class="btn btn-primary m-1" href="{{ route('show') }}" title="Voir mes billets">Voir mes billets</a>
				</p>
			</div>
			</div>
		</div>
	</div>
	</div>
</section>
</main>

@endsection