<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfosAchat extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'connected' 	=> 'required_without:new-client|boolean',
			'new-client' 	=> 'required_without:connected|boolean',
				'client-prenom' => 'required_if:new-client,1|string|between:2,100',
				'client-nom' 	=> 'required_if:new-client,1|string|between:2,100',
			'email' 		=> 'required_without:connected|email',
			'password' 	=> 'required_without:connected|string|between:6,40',

			'billet' 	=> 'required|array',
			'billet.*' 	=> 'required|array|min:1',

			'billet.*.seance' 	=> 'required|integer|between:0,2',
			'billet.*.tarif' 	=> 'required|string|in:cotisant,mineur,etudiant,plein',
			'billet.*.prenom' 	=> 'required|string|between:2,100',
			'billet.*.nom' 		=> 'required|string|between:2,100',
		];
	}

	public function messages()
	{
		return [
			'agreePrint.required'	=> 'Vous devez vous engagez à imprimer vos billets.'
		];
	}
}
