<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageStoreRequest extends FormRequest
{
    public function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->has('status') ? 1 : 0,
            'has_page_builder' => $this->has('has_page_builder') ? 1 : 0,
        ]);
    }
    public function authorize(): bool
    {
        return true; // Add policy logic if needed
    }

    public function rules(): array
    {
        return [
            'title'    => ['required', 'string', 'max:255'],
            'slug'     => ['required', 'string', 'max:255', 'unique:pages,slug'],
            'status'   => ['nullable', 'boolean'],
            'has_page_builder'   => ['nullable', 'boolean'],
            'blocks'   => ['nullable', 'array'], // builder JSON
            'blocks.*.type'    => ['required', 'string'],
            'blocks.*.content' => ['nullable', 'array'],
            'content' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'blocks.*.type.required' => 'Each block must have a type.',
        ];
    }
}