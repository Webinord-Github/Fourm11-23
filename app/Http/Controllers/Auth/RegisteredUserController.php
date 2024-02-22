<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Media;
use App\Models\Avatar;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\AutoEmail;
use App\Models\AutomaticEmail;
use Carbon;
use Auth;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $avatars = Media::where('path', '/storage/avatars/')->get();
        return view('auth.register')->with([
            'avatars' => $avatars,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {


        $validatedData = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'pronoun' => ['string', 'max:255', 'nullable'],
            'used_agreements' => ['string', 'max:255', 'nullable'],
            'gender' => ['string', 'max:255', 'nullable'],
            'title' => ['required', 'string', 'max:255'],
            'environment' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'years_xp' => ['numeric', 'nullable'],
            'work_city' => ['required', 'string', 'max:255'],
            'work_phone' => ['required', 'string', 'max:255'],
            'description' => ['string', 'max:400', 'nullable'],
            'audience' => ['array'],
            'audience.*' => ['string', 'max:255'],
            'other_audience' => ['nullable', 'string', 'max:255'],
            'interests' => ['array'],
            'interests.*' => ['string', 'max:255'],
            'other_interests' => ['nullable', 'string', 'max:255'],
            'about' => ['string', 'max:255', 'nullable'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'file' => ['nullable', 'file', 'mimes:jpeg,png,webp|max:8192'],
            'avatar_url' => ['nullable', 'string', 'max:255'],

        ], [
            'firstname.required' => 'Le champs est requis',
            'firstname.string' => "Format invalide",
            'firstname.max' => 'Le champs ne doit pas dépasser 255 caractères',
            'email.unique' => 'Ce courriel existe déjà.',
            'email_confirmation.same' => 'La confirmation du courriel ne correspond pas.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
        ]);

        // AUDIENCE
        $audience = $validatedData['audience'] ?? [];
        $otherAudience = $validatedData['other_audience'] ?? null;

        if (empty($audience) && !$otherAudience) {
            $audience = null;
        } elseif ($otherAudience) {
            $audience[] = $otherAudience;
        }

        // Convert audience array to a string
        $audienceString = $audience !== null ? implode(',', $audience) : null;

        // INTERESTS
        $interests = $validatedData['interests'] ?? [];
        $otherInterests = $validatedData['other_interests'] ?? null;

        if (empty($interests) && !$otherInterests) {
            $interests = null;
        } elseif ($otherInterests) {
            $interests[] = $otherInterests;
        }

        // Convert interests array to a string
        $interestsString = $interests !== null ? implode(',', $interests) : null;

        // NEWSLETTER
        $newsletter = $request->has('newsletter') ? true : false;
        // NOTIFICATIONS
        $notifications = $request->has('notifications') ? true : false;
        // CONDITIIONS
        $conditions = $request->has('conditions') ? true : false;


        $userData = [
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'pronoun' => $validatedData['pronoun'],
            'used_agreements' => $validatedData['used_agreements'],
            'gender' => $validatedData['gender'],
            'title' => $validatedData['title'],
            'environment' => $validatedData['environment'],
            'birthdate' => $validatedData['birthdate'],
            'years_xp' => $validatedData['years_xp'],
            'work_city' => $validatedData['work_city'],
            'work_phone' => $validatedData['work_phone'],
            'description' => $validatedData['description'],
            'audience' => $audienceString,
            'interests' => $interestsString,
            'hear_about' => $validatedData['about'],
            'newsletter' => $newsletter,
            'notifications' => $notifications,
            'conditions' => $conditions,
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'notifs_check' => now(),
            'verified' => false,
            'ban' => false,
        ];

        $user = User::create($userData);

        $memberRole = Role::where('name', 'Membre')->first();
        $user->roles()->attach($memberRole);
        $newUserid = User::where('id', $user->id)->get();
        
        if ($request->hasFile('file')) {
            $file_original_name = $request->file('file')->getClientOriginalName();
            $file_name_only = pathinfo($file_original_name, PATHINFO_FILENAME);
            $file_provider = pathinfo($file_original_name, PATHINFO_EXTENSION);
            $file_size = $request->file('file')->getSize() / 1024;
            $existing_file_url = Media::where('name', '=', $file_original_name)->first();
            $count_file = Media::where('original_name', '=', $file_original_name)->count();
            if($existing_file_url) {
                $file_name = $file_name_only . "_" . $count_file . "." . $file_provider;
            } else {
                $file_name = $file_original_name;
            }
            $media = new Media();
            $media->user_id = $user->id; // Use $user->id directly
            $media->path = '/storage/medias/';
            $media->name = $file_name;
            $media->original_name = $file_original_name;
            $media->size = $file_size;
            $media->provider = $file_provider;
            $media->save();
        
            // Store the file in storage/medias folder
            Storage::putFileAs('public/medias', $request->file('file'), $file_name);
        
            // Update user data with the image
            $user->image_id = $media->id;
            $user->save();
        } else {
            // If no file is uploaded, use the default avatar URL
            $user->image_id = 1;
            $user->save();
        }
      

        Auth::login($user);

        if ($request->filled('email')) {
            $to_email = $validatedData['email'];
            $automaticEmail = AutomaticEmail::where('id', 1)->first();
            $userFirstName = $userData['firstname'];
            $emailBody = "<h1 style='text-align:center;'>Inscription à La Fourmilière</h1><p>Bojour <strong>$userFirstName</strong>,</p>" . $automaticEmail->content;
            $customSubject = 'Courriel de la fourmilière';
            Mail::to($to_email)->send(new AutoEmail($emailBody, $customSubject));
            
            $userEmail = 'info@webinord.ca';
            $emailBodyAdmin = "<h1 style='text-align:center;'>Demande d'inscription à La Fourmilière</h1><p>Nouvelle demande d'inscription à la fourmilière</p>
            <p<strong>Nom complet:</strong>" . $validatedData['firstname'] . " " . $validatedData['lastname'] . "</p>
            <p><strong>Courriel:</strong>" . $validatedData['email'] .  "</p>
            ";
            Mail::to($userEmail)->send(new AutoEmail($emailBodyAdmin, $customSubject));
            

        }
        event(new Registered($user));
        return redirect('/');
    }
}
