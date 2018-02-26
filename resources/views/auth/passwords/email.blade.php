@extends('pages.template')
@section('content')

<main id="content">
<section class="slide bg-parchemin d-table">        
    <div class="d-table-cell align-middle"> 
    <div class="mx-auto bg-transparent rounded p-4" style="max-width: 600px;">
        
        <h2 class="text-center">Mot de passe oublié</h2>
        <hr>
        <br>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}
            <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 col-form-label">Votre adresse mail</label>
                <div class="col-md-8">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <p class="text-center">
                <button type="submit" class="btn btn-primary">Envoyer le lien de réinitialisation</button>
            </p>
        </form>

    </div>
    </div>
</section>
</main>

@endsection
