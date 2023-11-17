<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class BanUserController extends Controller
{
    public function index()
    {
        $user = User::where('ban', 1)->paginate();
        return view('admin.banusers.index')->with([
            'users' => $user
        ]);
    }

    public function unbanUser(Request $request)
    {
        // Find the user by userId
        $user = User::find($request->input('userId'));
        
        // Check if the user exists
        if ($user) {
            $user->update([
                'ban' => 0,
                'verified' => 0,
            ]);
     
            return response()->json(['message' => 'User banned successfully']);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }
}
