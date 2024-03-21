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
        $user = User::where('id', Auth::user()->id)->first();

        $user->notifs_check = now();
        $user->save();
        return response()->json(['message' => 'success']);
    }

    public function singleNotifsReadUpdate(Request $request, NotificationRead $notificationRead)
    {
        $user_id = Auth::id();
        $notif_id = $request->notif_id;

        $existingRecord = $notificationRead::where('user_id', $user_id)->where('notif_id', $notif_id)->first();

        if (!$existingRecord) {
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
