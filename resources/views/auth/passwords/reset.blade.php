@extends('pages.template')
@section('content')

<main id="content">
<section class="slide bg-parchemin d-table">        
    <div class="d-table-cell align-middle"> 
    <div class="mx-auto bg-transparent rounded p-4" style="max-width: 600px;">
        
        <h2 class="text-center">Réinitialiser votre mot de passe</h2>
        <hr>
        <br>
        <form method="POST" action="{{ route('password.request') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 col-form-label">Votre adresse mail</label>
                <div class="col-md-8">
                    <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 col-form-label">Nouveau mot de passe</label>
                <div class="col-md-8">
                    <input id="password" type="password" class="form-control" name="password" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password-confirm" class="col-md-4 col-form-label">Confirmer le mot de passe</label>
                <div class="col-md-8">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
            </div>
        </form>


    </div>
    </div>
</section>
</main>

@endsection
