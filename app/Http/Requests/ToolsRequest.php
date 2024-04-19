<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToolsRequest extends FormRequest
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
            'source' => 'required|string',
            'site_link' => 'string|nullable',
            'media' => 'file|mimes:pdf,docx|nullable',
            'thematiques' => 'array|min:1|max:3'
        ];
    }

    public function messages(){
        return [
            'thematiques.max' => "Seulement 3 thématiques peuvent être sélectionnées.",
            'thematiques.min' => "Au moins une thématique doit être sélectionnée.",
        ];
    }
}
