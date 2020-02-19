<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Rules\CanBeAuthor;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'content' => 'required',
            'author_id' => ['exists:users,id', new CanBeAuthor],
            'slug' => 'unique:posts,slug,' . (optional($this->post)->id ?: 'NULL'),
            'is_active' => 'required|boolean',
            'categories' => 'array',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('title')),
            'is_active' => (int) $this->is_active === 1,
        ]);
    }
}
