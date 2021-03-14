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

	
    public function messages()
    {
        return [
            'first_name.required' => 'الاسم غير مدخل، يرجى إدخال الاسم بالشكل الصحيح.',
            'email.required' => 'البريد الإلكتروني خطأ، يرجى إدخال بريد إلكتروني صحيح وفعال.',
            'email.email' => 'البريد الإلكتروني خطأ، يرجى إدخال بريد إلكتروني صحيح وفعال.',
            'email.unique' => 'البريد الإلكتروني موجود مسبقاً، يرجى إدخال بريد إلكتروني جديد.',
            'father_name.required' => 'الاسم غير مدخل، يرجى إدخال الاسم بالشكل الصحيح.',
            'grandfather_name.required' => 'الاسم غير مدخل، يرجى إدخال الاسم بالشكل الصحيح.',
            'last_name.required' => 'الاسم غير مدخل، يرجى إدخال الاسم بالشكل الصحيح.',
            'mobile.required' => 'رقم التواصل خطأ، يرجى إدخال رقم تواصل صحيح وفعال.',
			'mobile2' => 'رقم التواصل خطأ، يرجى إدخال رقم تواصل صحيح وفعال.',
            'id_number.required' => 'رقم الهوية خطأ، يرجى إدخال رقم هوية صحيح.',
            'city.required' => 'المنطقة غير مدخلة، يرجى إدخال اسم المنطقة بالشكل الصحيح.',
			'street.required' => 'العنوان غير مدخل، يرجى إدخال العنوان بالشكل الصحيح.',
            'id_number.unique' => 'رقم الهوية مدرج مسبقاً في النظام.',
            'governorate.required' => 'المحافظة غير مدخلة، يرجى اختيار المحافظة بالشكل الصحيح.',
        ];
    }
}
