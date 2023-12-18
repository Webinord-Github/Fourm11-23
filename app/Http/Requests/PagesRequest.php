<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PagesRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'url' => 'required|string|:max:255|unique:pages,url',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'url.required' => "URL is required",
            'url.unique' => "l'URL existe déjà",
        ];
    }
}
