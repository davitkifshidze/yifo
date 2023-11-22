<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

        $nameRules = [];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $locale) {
            $nameRules["name.{$localeCode}"] = 'string|min:3|max:64';
        }

        $requiredWithoutAllRules = [];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $locale) {
            $otherLocales = array_diff(array_keys(LaravelLocalization::getSupportedLocales()), [$localeCode]);
            $requiredWithoutAllRules["name.{$localeCode}"] = 'required_without_all:' . implode(',', array_map(function ($otherLocale) {
                    return "name.{$otherLocale}";
                }, $otherLocales));
        }

        return array_merge($nameRules, $requiredWithoutAllRules, [
            'description' => 'max:2048',
            'slug' => [
                'required',
                'string',
                Rule::unique('authors', 'slug')->ignore($id),
                'regex:/^[a-zA-Z-]+$/',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('authors', 'email')->ignore($id),
            ],
        ]);

    }
}
