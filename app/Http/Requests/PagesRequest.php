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
            'meta_title' => 'string|:max:60|required',
            'meta_desc' => 'string|:max:160|required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'url.required' => "URL is required",
            'url.unique' => "l'URL existe déjà",
            'meta_title.max' => "Le méta titre ne peux pas dépasser 60 charactères.",
            'meta_title.required' => "Le méta titre ne peut pas être vide.",
            'meta_desc.max' => "La méta description ne peux pas dépasser 160 charactères.",
            'meta_desc.required' => "La méta description ne peut pas être vide.",
        ];
    }
}
