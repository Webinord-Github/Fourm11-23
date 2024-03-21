<?php

namespace App\Http\Requests;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UpdateUserRequest extends FormRequest
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'pronoun' => 'string|max:255|nullable',
            'used_agreements' => 'string|max:255|nullable',
            'gender' => 'string|max:255|nullable',
            'title' => 'required|string|max:255',
            'environment' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'years_xp' => 'numeric|nullable',
            'work_city' => 'required|string|max:255',
            'work_phone' => 'required|string|max:255',
            'description' => 'string|max:400|nullable',
            'audience' => 'array',
            'audience.*' => 'string|max:255',
            'other_audience' => 'nullable|string|max:255',
            'interests' => 'array',
            'interests.*' => 'string|max:255',
            'other_interests' => 'nullable|string|max:255',
            'about' => 'string|max:255|nullable',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed', Rules\Password::defaults(),
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Name',
            'email.required' => 'Email',
            'email.unique' => 'Le courriel existe déjà',
        ];
    }
}
