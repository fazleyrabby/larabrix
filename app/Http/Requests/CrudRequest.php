<?php

namespace App\Http\Requests;

use App\Models\Crud;
use Illuminate\Foundation\Http\FormRequest;

class CrudRequest extends FormRequest
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
        // Retrieve product from route parameter or request attribute (depending on how your routes are set up)
        // $crud = $this->route('crud') ?? $this->crud;

        // Ensure product is an object before accessing 'id'
        $id = optional($this->route('crud'))->id ?? null;

        return [
            'title' => 'required|string|max:50|unique:cruds,title,' . $id,
            'textarea' => 'required|string|max:200',
            'default_file_input' => 'nullable|image',
            // 'filepond_input' => 'nullable|image',
            'custom_select' => 'required',
        ];
    }
}
