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
        $users = User::where('ban', 0)->paginate();

        return view('admin.usersguard.index', ['users' => $users]);
    }


    public function store(Request $request)
    {
        foreach($request->input('user_ids') as $userId) {
            $user = User::find($userId);
            if ($request->has('checkbox_'.$userId)) {
                $user->verified = 1;
            } else {
                $user->verified = 0;
            }
            $user->save();
        }
    
        // Add any additional logic you may need
    
        return redirect()->route('usersguard.index')->with('success', 'Les utilisateurs ont été mis à jour.');
    }

    public function banUser(Request $request)
    {
        // Find the user by userId
        $user = User::find($request->input('userId'));
        
        // Check if the user exists
        if ($user) {
            $user->update([
                'ban' => 1,
                'verified' => 0,
            ]);
     
            return response()->json(['message' => 'User banned successfully']);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }
}
