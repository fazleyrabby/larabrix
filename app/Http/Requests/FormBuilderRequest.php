<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormBuilderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'fields' => 'required|array',
            'fields.*.id' => 'nullable|exists:form_fields,id',
            'fields.*.type' => ['required', Rule::in(['text', 'email', 'textarea', 'select', 'checkbox', 'radio', 'file', 'multiselect'])],
            'fields.*.label' => 'required|string|max:255',
            'fields.*.name' => 'required|string|max:255',
            'fields.*.placeholder' => 'nullable|string|max:255',
            // 'fields.*.options' => 'nullable|array',
        ];
    }
}
