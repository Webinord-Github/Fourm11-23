<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $threshold = Carbon::now()->subMinutes(15);
        $loggedInUsers = User::where('last_activity', '>', $threshold)->get();
        $usersWithLastActivity = [];
        foreach ($users as $user) {
            $lastActivity = Carbon::parse($user->last_activity);
            $minutesDiff = Carbon::now()->diffInMinutes($lastActivity);
            $user->minutesDiff = $minutesDiff;
            $usersWithLastActivity[] = $user;
        }
        return view('admin.index')->with([
            'activeusers' => $loggedInUsers,
            'users' => $users,
            'minutesDiff' => $usersWithLastActivity,
        ]);
    }
}
