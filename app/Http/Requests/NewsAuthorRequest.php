<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsAuthorRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {

        $id = $this->route('id');

        if ($this->isMethod('post')) {

            return [
                'name' => 'required|string|min:3|max:64',
                'description' => 'max:1024',
                'slug' => 'required|unique:authors,slug',
                'facebook' => 'required|url',
                'email' => 'required|email|unique:authors',
            ];

        } else {

            return [
                'name' => 'required|string|min:3|max:64',
                'description' => 'max:1024',
                'slug' => [
                    'required',
                    'string',
                    Rule::unique('authors', 'slug')->ignore($id)
                ],
                'facebook' => [
                    'required',
                    'url',
                    Rule::unique('authors', 'facebook')->ignore($id)
                ],
                'email' => [
                    'required',
                    'email',
                    Rule::unique('authors', 'email')->ignore($id)
                ],
            ];

        }

    }
}
