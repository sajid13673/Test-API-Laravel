<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required|string|max:50|regex:/(^([a-zA-z 0-9-]+)(\d+)?$)/u',
            'description' => 'required|string|max:250',
            'image' => 'image|mimes:jpg|max:4096'
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
            'name.max' => 'Name can be maximum of 50 characters',
            'description.required' => 'Description is required!',
            'description.max' => 'Description can be maximum of 250 characters',
            'image.mimes' => 'Image should be jpeg,png,jpg in type',
            'image.max' => 'image should be maximum of 4mb',
        ];
    }
}
