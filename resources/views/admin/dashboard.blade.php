@extends("template")

@section("content")

	<div class="container my-4">
		<h1 class="my-4">Dashboard</h1>
		<hr class="my-4">
		
		<div class="row">
			<ul class="list-group col-md-4">
				<li class="list-group-item"><a class="btn-block" href="{{ route('admin.present') }}">Voir les billets présents</a></li>
				<li class="list-group-item"><a class="btn-block" href="https://analytics.google.com/analytics/web/">Google Analytics</a></li>
				<li class="list-group-item"><a class="btn-block" href="{{ route('admin.achetes') }}">Voir les billets achetés</a></li>
				<li class="list-group-item"><a class="btn-block" href="{{ route('admin.listAll') }}">Voir toutes les infos</a></li>
			</ul>
		</div>
	</div>

@endsection