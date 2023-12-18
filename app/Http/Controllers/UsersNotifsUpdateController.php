<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use App\Models\NotificationRead;
use Illuminate\Http\Request;
use Carbon;
use Auth;

class UsersNotifsUpdateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateNotifsCheck(Request $request)
    {
        $foundUser = User::find(Auth::id());
        $foundUser->update(['notifs_check' => now()]);

        return response()->json(['message' =>  $foundUser->notifs_check]);
    }

    public function singleNotifsReadUpdate(Request $request, NotificationRead $notificationRead)
    {
        $user_id = Auth::id();
        $notif_id = $request->notif_id;
    
        $existingRecord = $notificationRead::where('user_id', $user_id)->where('notif_id', $notif_id)->first();
    
        if(!$existingRecord){
            $notificationRead->user_id = $user_id;
            $notificationRead->notif_id = $notif_id;
            $notificationRead->save();
        } else {
          $notificationRead->update([
            'notif_id' => $notif_id,
            'user_id' => $user_id
          ]);
        }
    }
}
