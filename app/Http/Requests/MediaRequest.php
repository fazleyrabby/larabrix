<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'images' => 'required|array',
            'images.*' => 'file|max:2000|mimes:jpeg,jpg,png'
        ];
    }

    public function messages(): array
    {
        return [
            'images.*.max' => 'File Size Cannot be more than 2000kb',
            'images.*.mimes' => 'File format supported: jpeg,jpg,png',
        ];
    }
}
