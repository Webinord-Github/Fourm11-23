<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset as ModelsPasswordReset;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Carbon;


class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request)
    {
        $token = $request->token;
        $passwordReset = ModelsPasswordReset::where('email', $request->email)->first();
    
        if ($passwordReset) {
            $requestCreatedAt = Carbon::parse($request->created_at);
            $passwordResetCreatedAt = Carbon::parse($passwordReset->created_at);
            
            // Check if the difference between the two timestamps is more than 60 minutes
            $isMoreThan60Minutes = $requestCreatedAt->diffInMinutes($passwordResetCreatedAt) > 60;
    
            if ($isMoreThan60Minutes) {
                return redirect('/lien-invalide');
            }
    
            return view('auth.reset-password')->with([
                'request' => $request,
            ]);
        }
        return redirect('/lien-invalide');
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.exists' => 'Courriel invalide.',
            'password.confirmed' => 'Confirmation de mot de passe invalide.'
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Mot de passe modifié avec succès!')
            : back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
