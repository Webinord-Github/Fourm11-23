<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Conversation;
use App\Models\Event;
use App\Models\User;

class SearchBarController extends Controller
{
    public function searchBar(Request $request)
    {
        // Assuming 'data' is the parameter you are sending in the AJAX request
        $searchTerm = $request->input('data');

        // Modify the search logic to check for two consecutive letters in the title
        $pages = Page::where(function ($query) use ($searchTerm) {
            $length = strlen($searchTerm);

            // Construct a regular expression for two consecutive letters in the search term
            $regex = '';
            for ($i = 0; $i < $length; $i++) {
                $regex .= $searchTerm[$i] . '.?'; // .? matches any character (except newline) zero or one time
            }

            // Use the regular expression in the query
            $query->where('title', 'REGEXP', $regex);
        })->get();
        $conversations = Conversation::where(function ($query) use ($searchTerm) {
            $length = strlen($searchTerm);

            // Construct a regular expression for two consecutive letters in the search term
            $regex = '';
            for ($i = 0; $i < $length; $i++) {
                $regex .= $searchTerm[$i] . '.?'; // .? matches any character (except newline) zero or one time
            }

            // Use the regular expression in the query
            $query->where('title', 'REGEXP', $regex);
            $query->where('published', true);
        })->get();
        $events = Event::where(function ($query) use ($searchTerm) {
            $length = strlen($searchTerm);

            // Construct a regular expression for two consecutive letters in the search term
            $regex = '';
            for ($i = 0; $i < $length; $i++) {
                $regex .= $searchTerm[$i] . '.?'; // .? matches any character (except newline) zero or one time
            }

            // Use the regular expression in the query
            $query->where('title', 'REGEXP', $regex);
            $query->where('published', true);
        })->get();
        $users = User::where(function ($query) use ($searchTerm) {
            $length = strlen($searchTerm);

            // Construct a regular expression for two consecutive letters in the search term
            $regex = '';
            for ($i = 0; $i < $length; $i++) {
                $regex .= $searchTerm[$i] . '.?'; // .? matches any character (except newline) zero or one time
            }

            // Use the regular expression in the query
            $query->where('firstname', 'REGEXP', $regex)
            ->where('verified', true)
            ->where('ban', false)
            ->orWhere('lastname', 'REGEXP', $regex);

        
        })->get();

        // You can customize the response based on your needs
        return response()->json([
            'pages' => $pages,
            'conversations' => $conversations,
            'events' => $events,
            'users' => $users,
        ]);
    }
}
