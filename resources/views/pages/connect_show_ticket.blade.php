@extends('pages.template')
@section('content')

<main id="content">
<section class="slide bg-parchemin d-table">        
    <div class="d-table-cell align-middle"> 
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center mb-3">
                <h1 class="d-inline-block box m-0">Billetterie</h1>
            </div>

            <!-- Formulaire -->
            <div class="col-md-8">
            <div class="box">
                <h3>Veuillez rentrer vos informations : </h3>

                <form action="" method="POST">
                    <fieldset class="form-group">
                        <label for="form-name" class="form-control-label">Nom entré lors de la commande :</label>
                        <input id="form-name" type="text" class="form-control" name="name" required>
                        <small id="fb-name" class="form-control-feedback" style="display: none;"></small>
                    </fieldset>
                    
                    <fieldset class="form-group">
                        <label for="form-name" class="form-control-label">Numéro de commande (ou billet, a voir) :</label>
                        <input id="form-name" type="text" class="form-control" name="name" required>
                        <small id="fb-name" class="form-control-feedback" style="display: none;"></small>
                    </fieldset>

                    <input id="form-submit" class="btn btn-primary" type="submit" name="submit" value="Voir mes billets">
                </form>
            </div>
            </div>
        </div>
    </div>
    </div>
</section>
</main>

@endsection
