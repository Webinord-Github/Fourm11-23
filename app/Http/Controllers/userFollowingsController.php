<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserFollow;
use Auth;

class userFollowingsController extends Controller
{
    public function userFollowing(Request $request)
    {
        $validatedData = $request->validate([
            'followingid' => ['numeric'],
        ]);
        $followerid = Auth::user()->id;

        $existingFollow = UserFollow::where('follower_id', $followerid)
        ->where('following_id', $validatedData['followingid'])
        ->first();
        if(!$existingFollow) {
            $newFollow = new UserFollow();
            $newFollow->follower_id = $followerid;
            $newFollow->following_id = $validatedData['followingid'];
            $newFollow->save();
        } else {
            $existingFollow->delete();
        }
        return response()->json([
            'message' => 'success',
        ]);
    }
}
