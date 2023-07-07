<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsCategoryRequest extends FormRequest
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
                'name' => 'required|text|min:3|max:64',
                'description' => 'max:1024',
                'slug' => 'required|unique:categories,slug',
            ];
        } else {

            return [
                'name' => 'required|text|min:3|max:64',
                'description' => 'max:1024',
                'slug' => [
                    'required',
                    'string',
                    Rule::unique('categories', 'slug')->ignore($id)
                ],

            ];
        }


    }
}
