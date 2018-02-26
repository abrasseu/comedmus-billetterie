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
                <h3>Votre paiement est confirmé</h3>

                <p>Vous allez recevoir un mail contenant votre (vos) billet(s), vous pouvez également le (les) télécharger directement : </p>

                <a class="btn btn-primary m-1" href="fpdf-billetterie-com/index.php" title="Billet">Billet extérieur</a>
                <a class="btn btn-primary m-1" href="#" title="Billet">Billet cotisant</a>
                <a class="btn btn-primary m-1" href="#" title="Billet">Billet mineur</a>
            </div>
            </div>
        </div>
    </div>
    </div>
</section>
</main>

@endsection