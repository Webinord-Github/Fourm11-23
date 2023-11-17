<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersGuardController extends Controller
{
    public function index()
    {
        $users = User::paginate();

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
}
