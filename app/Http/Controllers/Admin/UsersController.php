<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;
use App\Models\AutomaticEmail;
use App\Mail\AutoEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Chat;
use Auth;
use Carbon\Carbon;

class UsersController extends Controller
{

    public function __construct() {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  
    public function index()
    {     
        return view('admin.users.index', [
            'model' => User::all(),
            'authuser' => Auth::user()->id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create')->with([
            'model' => new User(),
            'roles' => Role::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'pronoun' => ['string', 'max:255', 'nullable'],
            'used_agreements' => ['string', 'max:255', 'nullable'],
            'gender' => ['string', 'max:255', 'nullable'],
            'title' => ['required', 'string', 'max:255', 'nullable'],
            'environment' => ['required', 'string', 'max:255', 'nullable'],
            'birthdate' => ['required', 'date', 'nullable'],
            'years_xp' => ['numeric', 'nullable'],
            'work_city' => ['required', 'string', 'max:255', 'nullable'],
            'work_phone' => ['required', 'string', 'max:255', 'nullable'],
            'description' => ['string', 'max:400', 'nullable'],
            'audience' => ['array', 'nullable'],
            'audience.*' => ['string', 'max:255', 'nullable'],
            'other_audience' => ['nullable', 'string', 'max:255'],
            'interests' => ['array', 'nullable'],
            'interests.*' => ['string', 'max:255', 'nullable'],
            'other_interests' => ['nullable', 'string', 'max:255'],
            'about' => ['string', 'max:255', 'nullable', 'nullable'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

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
            'description' => null,
            'audience' => $audienceString,
            'interests' => $interestsString,
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'notifs_check' => now(),
            'verified' => true,
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

        $user->roles()->sync($request->roles);

        return redirect()->route('users.index')->with('status', "Utilisateur: $user->firstname $user->lastname a été créé.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $userÈ
     */
    public function show(User $user)
    {
        return view('frontend.profil', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
      
        return view('admin.users.edit', [
            'model' => $user,
            'roles' => Role::all(),
            'authuser' => Auth::user()->id,
            'authUserIsSuperAdmin' => Auth::user()->hasRole('Super Admin'),
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {        
        $validatedData = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'pronoun' => ['string', 'max:255', 'nullable'],
            'used_agreements' => ['string', 'max:255', 'nullable'],
            'gender' => ['string', 'max:255', 'nullable'],
            'title' => ['required', 'string', 'max:255'],
            'environment' => ['required', 'string', 'max:255'],
            'years_xp' => ['numeric', 'nullable'],
            'work_city' => ['required', 'string', 'max:255'],
            'work_phone' => ['required', 'string', 'max:255'],
            'audience' => ['array'],
            'audience.*' => ['string', 'max:255'],
            'other_audience' => ['nullable', 'string', 'max:255'],
            'interests' => ['array'],
            'interests.*' => ['string', 'max:255'],
            'other_interests' => ['nullable', 'string', 'max:255'],
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

        $user->firstname = $validatedData['firstname'];
        $user->lastname = $validatedData['lastname'];
        $user->pronoun = $validatedData['pronoun'];
        $user->used_agreements = $validatedData['used_agreements'];
        $user->gender = $validatedData['gender'];
        $user->title = $validatedData['title'];
        $user->environment = $validatedData['environment'];
        $user->years_xp = $validatedData['years_xp'];
        $user->work_city = $validatedData['work_city'];
        $user->work_phone = $validatedData['work_phone'];
        $user->audience = $audienceString;
        $user->interests = $interestsString;
        $user->verified = $request->has('checkbox') ? true : false;

        $user->save();
        $user->roles()->sync($request->roles);

        return redirect()->route('users.index')->with('status', "Utilisateur: $user->firstname $user->lastname a été modifié.");
    }

    public function updateUserPassword(Request $request, User $user)
    {

        if(Auth::user()->id != $user->id && Auth::user()->hasRole('Super Admin')) {   
            $validated = $request->validateWithBag('updatePassword', [
                'password' => ['required', Password::defaults(), 'confirmed'],
            ]);
        }
        else {
            $validated = $request->validateWithBag('updatePassword', [
                'current_password' => ['required', 'current_password'],
                'password' => ['required', Password::defaults(), 'confirmed'],
            ]);
        }
            
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        
        return back()->with('status', 'updated-password');
   
            
        
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('status', "user->firstname $user->lastname a été supprimé.");
    }  

    
}
