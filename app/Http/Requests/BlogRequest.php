<?php

namespace App\Http\Requests;

use App\Models\Blog;
use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
        $blog = $this->route('blog') ?? $this->blog;
        $id = $blog instanceof Blog ? $blog->id : (is_string($blog) ? $blog : null);

        return [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'slug' => 'required|regex:/^[^\s]+$/|string|unique:blogs,slug,' . $id,
            'is_published' => 'nullable|boolean',
        ];
    }
}
