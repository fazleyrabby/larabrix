<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageUpdateRequest extends FormRequest
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
        return true;
    }

    public function rules(): array
    {
        $pageId = $this->route('page'); // Assuming route model binding
        return [
            'title'    => ['required', 'string', 'max:255'],
            'slug'     => ['required', 'string', 'max:255', Rule::unique('pages', 'slug')->ignore($pageId)],
            'status'   => ['nullable', 'boolean'],
            'has_page_builder'   => ['nullable', 'boolean'],
            'blocks'   => ['nullable', 'array'],
            'content' => ['nullable', 'string'],
            'blocks.*.type'    => ['required', 'string'],
            'blocks.*.content' => ['nullable', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'blocks.*.type.required' => 'Each block must have a type.',
        ];
    }
}