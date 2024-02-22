<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Media;
use App\Models\Post;
use App\Models\Postmark;
use App\Models\BookmarkThematiques;
use App\Models\Event;
use App\Models\Thematique;
use App\Models\Tool;
use App\Models\Conversation;
use App\Models\Signet;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function show($id)
    {   
        if(User::where('id', $id )->exists()) {
            if(Auth::user()->id == $id){
                $user = Auth::user();

                $posts = [];
                $postmarks = Postmark::where('user_id', $user->id)->get();
                foreach($postmarks as $postmark) {
                    $posts[] = Post::where('status', 'publié')->where('published_at', '<', Carbon::tomorrow())->where('id', $postmark->post_id)->first();
                }

                $tools = [];
                $toolmarks = Signet::where('user_id', $user->id)->get();
                foreach($toolmarks as $toolmark) {
                    $tools[] = Tool::where('status', 'publié')->where('published_at', '<', Carbon::tomorrow())->where('id', $toolmark->tool_id)->first();
                }

                $convos =  Conversation::all();

                $events = Event::all();

                $themes = [];
                $thememarks = BookmarkThematiques::where('user_id', $user->id)->get();
                foreach($thememarks as $thememark) {
                    $themes[] = Thematique::where('id', $thememark->thematique_id)->first();
                }

                $users = User::all();

                $avatars = Media::where('path', '/storage/avatars/')->get();

                return view('frontend.profil')->with([
                    'user' => $user,
                    'posts' => $posts,
                    'tools' => $tools,
                    'convos' => $convos,
                    'events' => $events,
                    'themes' => $themes,
                    'users' => $users,
                    'avatars' => $avatars,
                ]);
            } else {
                return Redirect::to('/membre/' . $id);
            }
        } else {
            return Redirect::to('/');
        }
    }

    public function updateProfile(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'pronoun' => ['string', 'max:255', 'nullable'],
            'used_agreements' => ['string', 'max:255', 'nullable'],
            'gender' => ['string', 'max:255', 'nullable'],
            'title' => ['required', 'string', 'max:255'],
            'environment' => ['required', 'string', 'max:255'],
            'years_xp' => ['numeric', 'nullable'],
            'work_city' => ['required', 'string', 'max:255'],
            'work_phone' => ['required', 'string', 'max:255'],
            'description' => ['string', 'max:400', 'nullable'],
            'audience' => ['array'],
            'audience.*' => ['string', 'max:255'],
            'other_audience' => ['nullable', 'string', 'max:255'],
            'interests' => ['array'],
            'interests.*' => ['string', 'max:255'],
            'other_interests' => ['nullable', 'string', 'max:255'],
        ]);

        // AUDIENCE
        $audience = $validatedData['audience'] ?? [];
        $otherAudience = $validatedData['other_audience'] ?? null;

        if (empty($audience) && !$otherAudience) {
            $audience = null;
        } elseif ($otherAudience) {
            $audience[] = $otherAudience;
        }

        // Convert audience array to a string
        $audienceString = $audience !== null ? implode(',', $audience) : null;

        // INTERESTS
        $interests = $validatedData['interests'] ?? [];
        $otherInterests = $validatedData['other_interests'] ?? null;

        if (empty($interests) && !$otherInterests) {
            $interests = null;
        } elseif ($otherInterests) {
            $interests[] = $otherInterests;
        }

        // Convert interests array to a string
        $interestsString = $interests !== null ? implode(',', $interests) : null;

        $user->pronoun = $validatedData['pronoun'];
        $user->used_agreements = $validatedData['used_agreements'];
        $user->gender = $validatedData['gender'];
        $user->title = $validatedData['title'];
        $user->environment = $validatedData['environment'];
        $user->years_xp = $validatedData['years_xp'];
        $user->work_city = $validatedData['work_city'];
        $user->work_phone = $validatedData['work_phone'];
        $user->description = $validatedData['description'];
        $user->audience = $audienceString;
        $user->interests = $interestsString;

        $user->save();
        return back()->with('status', 'updated-infos');
    }

    public function membre($id)
    {
        if(User::where('id', $id )->exists()) {
            $user = User::find($id);
            return view('frontend.membre')->with('user', $user);
        } else {
            return Redirect::to('/');
        }
    }
}
