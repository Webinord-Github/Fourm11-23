<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Notification;
use App\Models\Conversation;
use App\Models\Reply;
use App\Models\NotificationRead;
use App\Models\ConversationBookmarks;
use App\Providers\Route;
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
                $conversations = Conversation::with('replies')->get();
                $conversationBookmarks = ConversationBookmarks::where('user_id', Auth::user()->id)->get();
                $notifications = Notification::orderBy('updated_at', 'desc')->get(); // Fetch notifications in descending order
                $notifsCheck = strtotime(auth()->user()->notifs_check);
                $notificationRead = NotificationRead::all(); // Retrieve all notification reads
                $replies = Reply::all();
       
                $view->with([
                    'notifications' => $notifications,
                    'notifsCheck' => $notifsCheck,
                    'notificationRead' => $notificationRead, // Pass notification read data to the view
                    'replies' => $replies,
                    'conversationsWithReplies' => $conversations,
                    'conversationBookmarks' => $conversationBookmarks,
                ]);
         
            }
        });
    }
}
