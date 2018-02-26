<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModifyRequest extends FormRequest
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
            'id'     => 'required|integer|exists:billets,id',
            'prenom' => 'required|string|between:2,100',
            'nom'    => 'required|string|between:2,100'
            // 'navette'=> 'boolean'
        ];
    }
}
