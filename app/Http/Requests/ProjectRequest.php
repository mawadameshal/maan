<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            //'supervisor' => 'required|max:50',
            'name' => 'required|max:191',
			//'manager' => 'required|max:50',
            //'coordinator' => 'required|max:50',
            'code' => 'required|max:50',
            'code' => 'required|max:50',
//            'active' => 'required|max:300',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];
    }
}
