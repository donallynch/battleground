<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePlayerPost extends FormRequest
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
            'name' => 'required|unique:users|min:3|max:255',
            'gold' => 'required|min:0|max:1000000000',
            'strength' => 'required|min:0|max:100',
            'health' => 'required|min:0|max:100',
            'luck' => 'required|min:0|max:1'
        ];
    }
}
