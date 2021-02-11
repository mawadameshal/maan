<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormsRequest extends FormRequest
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
            'type' => 'required|integer|max:50',
            'sent_type' => 'required|numeric|digits_between:1,10',
            'project_id' => 'required|numeric|digits_between:1,10',
            'citizen_id' => 'required|numeric|digits_between:1,10',
            'title' => 'required|max:200',
            'category_id' => 'required|numeric|digits_between:1,10',
            'content' => 'required|max:1000',
        ];
    }
}
