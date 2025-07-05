<?php

namespace App\Http\Requests;

use App\Models\Attribute;
use Illuminate\Foundation\Http\FormRequest;

class AttributeRequest extends FormRequest
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
        $attribute = $this->route('attribute') ?? $this->attribute;
        $id = $attribute instanceof Attribute ? $attribute->id : (is_string($attribute) ? $attribute : null);

        $rules = [
            'title' => 'required|string|max:255|unique:attributes,title,' . $id,
            'slug' => 'nullable|string|max:255|unique:attributes,slug,' . $id
        ];

        foreach ($this->input('values', []) as $key => $value) {
            $rules["values.$key.title"] = 'required|string|max:255';
            $rules["values.$key.slug"]  = 'nullable|string|max:255';
        }

        return $rules;
    }
}
