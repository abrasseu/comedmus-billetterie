@extends('pages.template')
@section('content')

<main id="content">
<section class="slide bg-parchemin d-table">        
	<div class="d-table-cell align-middle"> 
	<div class="mx-auto bg-transparent rounded p-4" style="max-width: 600px;">
		
		<h2 class="text-center">Se connecter</h2>
		<hr>
		<br>
		<form method="POST" action="{{ route('login') }}">
			{{ csrf_field() }}
			<div class="form-group row">
				<label for="email" class="col-md-4 col-form-label">Adresse email</label>
				<div class="col-md-8">
					<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
					@if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
				</div>
			</div>
			<div class="form-group row">
				<label for="password" class="col-md-4 col-form-label">Mot de passe</label>
				<div class="col-md-8">
					<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
					@if ($errors->has('password'))
						<span class="help-block">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
					@endif
				</div>
			</div>
			<div class="form-group">
				<label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Rester connecté</label>
			</div>

			<div class="d-flex justify-content-around flex-wrap">
				<a class="col-12 col-md-5 btn btn-link m-1" href="{{ route('password.request') }}">Mot de passe oublié</a>
				<button type="submit" class="col-12 col-md-5 btn btn-primary m-1">Se connecter</button>
			</div>
		</form>

	</div>
	</div>
</section>
</main>

@endsection
