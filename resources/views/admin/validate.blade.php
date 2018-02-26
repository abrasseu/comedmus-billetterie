@extends("template")

@section("content")

	<div class="container my-4">
		<h1 class="my-4">Valider un billet</h1>
		<hr class="my-4">

		@if ($errors->any())
			<div class="alert alert-danger">
				@foreach ($errors->all() as $error)
					<p class="lead text-center m-0">{!! $error !!}</p>
				@endforeach
			</div>
		@endif
		@if (session("success"))
			<div class="alert alert-success">
				<p class="lead text-center m-0">{{ session("success") }}</p>
			</div>
		@endif

		<form action="{{ route('admin.validateForce') }}" method="POST" accept-charset="utf-8" class="mx-auto" style="max-width: 300px;">
			{{ csrf_field() }}
			<fieldset class="form-group">
				<label for="id" class="form-control-label">ID du billet:</label>
				<input id="id" type="number" class="form-control" name="id" required autofocus>
			</fieldset>
			<p class="text-center">
				<input id="submitForm" class="btn btn-block btn-primary" type="submit" value="Valider le billet">
			</p>			
		</form>
	</div>

@endsection