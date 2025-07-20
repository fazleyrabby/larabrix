<?php

namespace App\Http\Requests;

use App\Enums\MenuType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class MenuRequest extends FormRequest
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
            'title'      => ['required', 'string', 'max:255'],
            'text'       => ['nullable', 'string', 'max:255'],
            'href'       => ['nullable', 'string', 'max:255'],
            'target'     => ['nullable', 'string', 'in:_self,_blank'],
            'slug'       => ['required', 'string'],
            'parent_id'  => ['nullable', 'integer'],
            'status'     => ['nullable', 'boolean'],
            'icon'       => ['nullable', 'string', 'max:255'],
            'image'      => ['nullable', 'string', 'max:255'],
            'position'   => ['nullable', 'integer'],
            'type'       => ['required', new Enum(MenuType::class)],
            // 'language' => ['nullable', 'json'],
        ];
    }
}
