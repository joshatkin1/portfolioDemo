<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRegisterRequest extends FormRequest
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
            'company_name' => 'required|string|min:1|max:255',
            'company_industry' => 'required|string|max:255',
            'company_email' => 'required|email',
            'company_telephone' => 'required|max:255',
        ];
    }

    public function message()
    {
        return [
        ];
    }
}
