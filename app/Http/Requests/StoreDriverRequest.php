<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDriverRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'image'             =>  'nullable|image',
            'first_name_ar'     =>  'nullable|string',
            'first_name_fr'     =>  'nullable|string',
            'last_name_ar'      =>  'nullable|string',
            'last_name_fr'      =>  'nullable|string',
            'role_ar'           =>  'nullable|string',
            'role_fr'           =>  'nullable|string',
            'cin'               =>  'nullable|string',
            'permisType.*'      =>  'required',
            'permisType'        =>  'required',
            'phone'             =>  'nullable|string',
        ];
    }
}

