<div class="billet">
	<hr>
	<div class="row">
		<div class="col-md-6">
			<h5 class="mb-0">Billet</h5>
		</div> 
		<div class="col-md-6 text-right">'
			+ ((billetCounter > 1) ? '<button type="button" class="btn btn-link pr-0 billet-remove">Supprimer</button>' : '') +
		'</div>
	</div>
	<div class="row">
		<div class="col-lg-6"><fieldset class="form-group">
			<label for="form-seance">Séance :</label>
			<select class="form-control billet-seance" name="billet['+billetCounter+'][seance]" required>
				{!! ($nbBilletsRestant[0] > 0 ? '<option value="0">Jeudi 14 Décembre - 20:00</option>' : '') !!}
				{!! ($nbBilletsRestant[1] > 0 ? '<option value="1">Vendredi 15 Décembre - 20:00</option>' : '') !!}
				{!! ($nbBilletsRestant[2] > 0 ? '<option value="2">Samedi 16 Décembre - 20:00</option>' : '') !!}
			</select>
		</fieldset></div>
		<div class="col-lg-6"><fieldset class="form-group">
			<label for="form-tarif">Tarif :</label>
			<select class="form-control billet-tarif" name="billet['+billetCounter+'][tarif]" required>
				@foreach ($tarifsArr as $tarif)
					@continue($tarif=='cotisant' && !session()->has('login'))
					<option value="{{ $tarif }}" {{ ($tarif=='cotisant') ? 'selected' : ''}}>{{ $tarifs[$tarif] }} - {{ $prix[$tarif] }}€</option>
				@endforeach
			</select>
		</fieldset></div>
	</div>
	<div class="row">
		<div class="col-md-6"><fieldset class="form-group">
			<input class="form-control billet-tarif" type="text" name="billet['+billetCounter+'][prenom]" placeholder="Prénom" required>
		</fieldset></div>
		<div class="col-md-6"><fieldset class="form-group">
			<input class="form-control billet-tarif" type="text" name="billet['+billetCounter+'][nom]" placeholder="Nom" required>
		</fieldset></div>
	</div>
</div>