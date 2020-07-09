<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AlumnusUpdateRequest extends FormRequest
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
            'first_name' => 'required|max:40',
            'last_name' => 'required|max:40',
            'gender' => 'required|in:m,f',
            'street' => 'max:80',
            'street_number' => 'max:40',
            'postcode' => 'max:40',
            'city' => 'max:40',
            'email' => 'required|email|unique:alumni,email,' . $this->alumnus->id,
            'password' => 'nullable|min:6',
            'experiences' => 'array|sometimes',
            'experiences.education' => 'array|sometimes',
            'experiences.work' => 'array|sometimes',
            'alumni_year' => 'max:4',
            'telephone' => 'max:50',
            'mobile' => 'max:50',
            "image" => "image"
        ];
    }
}
