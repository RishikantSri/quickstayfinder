<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        
        return [
            'name' => 'required',
            'city_id' => 'required|exists:cities,id',
            'address_street' => 'required',
            'address_postcode' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.reuired' => 'A  name is required for the post.',
            'city_id.required' => 'city id is required',
            'address_street.required' => 'address street  is required',
            'address_postcode.required' => 'address postcode  is required',
        ];
    }
}
