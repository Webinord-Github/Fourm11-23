<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Notification;
use App\Models\NotificationRead;
use Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            if(Auth::check()) {
                $notifications = Notification::orderBy('updated_at', 'desc')->get(); // Fetch notifications in descending order
                $notifsCheck = strtotime(auth()->user()->notifs_check);
                $count = 0;
                foreach($notifications as $notification) {
                    if(strtotime($notification->updated_at) > $notifsCheck) {
                        $count++;
                    }
                }
                $notificationRead = NotificationRead::all(); // Retrieve all notification reads

            
                $view->with([
                    'notifications' => $notifications,
                    'notifsCheck' => $notifsCheck,
                    'NotifsCount' => $count,
                    'notificationRead' => $notificationRead, // Pass notification read data to the view
                ]);
            }
        });
    }
}
