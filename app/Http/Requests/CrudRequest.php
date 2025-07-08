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
        $crud = $this->route('crud') ?? $this->crud;
        $id = $crud instanceof Crud ? $crud->id : (is_string($crud) ? $crud : null);

        return [
            'title' => 'required|string|max:50|unique:cruds,title,' . $id,
            'textarea' => 'required|string|max:200',
            'default_file_input' => 'nullable|image',
            'media_input' => 'nullable',
            // 'filepond_input' => 'nullable|image',
            'custom_select' => 'required',
        ];
    }
}
