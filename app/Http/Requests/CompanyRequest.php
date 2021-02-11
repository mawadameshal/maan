<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'title' => 'required|max:50',
            'welcom_word' => 'required|max:50',
            'welcom_clouse' => 'required|max:300',
            'add_compline_clouse' => 'required|max:300',
            'add_propusel_clouse' => 'required|max:300',
            'add_thanks_clouse' => 'required|max:300',
            'follw_compline_clouse' => 'required|max:300',
            'how_we' => 'required|min:60',
            'address' => 'required|max:60',
        ];
    }
}