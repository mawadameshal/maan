<?php

namespace App\Http\Requests;
use App\Rules\IdNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CitizenRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
        $id = $this->route('citizen');
        return [
			'first_name' => 'required|max:50',
			'email' => Rule::notIn(['email|max:50']),
			'father_name' => 'required|max:50',
			'grandfather_name' => 'required|max:50',
			'last_name' => ['required', 'max:50'],
            'id_number' => [new IdNumber(),],
            'governorate' => 'required|max:50',
			'city' => 'required|max:50',
			'street' => 'required|max:50',
			'mobile' => 'required|max:12|min:7',
            'mobile2' => 'max:12|min:7'
		];

	}
}
