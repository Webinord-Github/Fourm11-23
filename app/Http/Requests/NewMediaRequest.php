<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewMediaRequest extends FormRequest
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
            'file' => 'required|file|max:8092',
        ];
    }

    public function messages(){
        return [
            'file.required' => "Media",
            'file.file' => 'Not a file',
            'file.max' => 'Max file upload is 8 Mb'
        ];
    }
}
