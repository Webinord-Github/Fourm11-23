<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UniquePasswordToken implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Logic to check if the token is unique
        $users = User::all();
        foreach ($users as $user) {
            if (Hash::check($value, $user->password)) {
                return false; // Token matches an existing password hash
            }
        }
        return true; // Token is unique
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Le jeton doit être unique.';
    }
}
