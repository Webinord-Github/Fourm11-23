<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;

class UsersGuardController extends Controller
{
    public function index()
    {
        $users = User::where('ban', false)->paginate();

        return view('admin.usersguard.index', ['users' => $users]);
    }


    public function store(Request $request)
    {
        foreach ($request->input('user_ids') as $userId) {
            $user = User::find($userId);
            if ($request->has('checkbox_' . $userId)) {
                $user->verified = true;
            } else {
                $user->verified = false;
            }
            if ($request->has('checkbox_' . $userId) && !$user->approved_email == true) {
                $user->approved_email = true;
                $to_email = $user->email;
                $automaticEmail = AutomaticEmail::where('id', 3)->first();
                $userFirstName = $user->firstname;
                $emailBody = "<h1 style='text-align:center;'>Admission à La Fourmilière</h1><p>Bojour <strong>$userFirstName</strong>,</p>" . $automaticEmail->content;
                $customSubject = 'Courriel de la fourmilière';
                Mail::to($to_email)->send(new AutoEmail($emailBody, $customSubject));

                
            }
            $user->save();
        }

        // Add any additional logic you may need

        return redirect()->route('usersguard.index')->with('success', 'Les utilisateurs ont été mis à jour.');
    }

    public function banUser(Request $request)
    {
        // Find the user by userId
        $user = User::where('id', $request->userId)->firstOrFail();
        $user->ban = true;
        $user->verified = false;
        $user->save();
        return response()->json(['message' => 'done']);


   
        // if ($user->refused_email == false) {
        //     $user->refused_email = true;
        //     $to_email = $user->email;
        //     $automaticEmail = AutomaticEmail::where('id', 4)->first();
        //     $userFirstName = $user->firstname;
        //     $emailBody = "<h1 style='text-align:center;'>Refus d'admission à La Fourmilière</h1><p>Bojour <strong>$userFirstName</strong>,</p>" . $automaticEmail->content;
        //     $customSubject = 'Courriel de la fourmilière';
        //     Mail::to($to_email)->send(new AutoEmail($emailBody, $customSubject));
        //     return response()->json(['message' => 'User banned successfully']);
        // }
        
    }
}
