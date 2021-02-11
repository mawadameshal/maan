<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Form_followRequest extends FormRequest
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
            'form_id' => 'required|numeric|digits_between:1,10',
            'citizen_id' => 'required|numeric|digits_between:1,10',
            'solve' => 'required|numeric|digits_between:1,10',
            'evaluate' => 'required|numeric|digits_between:1,10',
            'notes' => 'max:190',
        ];
    }
}
