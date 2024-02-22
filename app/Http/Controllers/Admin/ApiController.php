<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;
use App\Models\Thematique;
use App\Models\Signet;
use App\Models\Post;
use App\Models\Conversation;
use App\Models\Postmark;
use App\Models\BookmarkThematiques;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class ApiController extends Controller
{
    public function tools() {
        $tools = Tool::where('status', 'publié')->where('published_at', '<', Carbon::yesterday())->get();
        echo json_encode($tools);
    }

    public function signets(Request $request)
    {
        $tool_id = $request->input('tool_id');
        $tool_id = (int)$tool_id;

        if(Auth::check()) {
            if(is_numeric($tool_id)) {
                $user_id = Auth::user()->id;
                $existing_signet = Signet::where('user_id', $user_id)->where('tool_id', $tool_id)->first();
    
                if(!$existing_signet) {
                    $signet = new Signet();
                    $signet->user_id = $user_id;
                    $signet->tool_id = $tool_id;
                    $signet->save();
                } else {
                    $existing_signet->delete();
                    return response()->json(['message' => 'delete']);
                }
                
                return response()->json(['message' => 'add']);
            } else {
                return response()->json(['message' => "error"]);
            }
        } else {
            return response()->json(['message' => "user"]);
        }
    }

    public function postsBookmarks(Request $request)
    {
        $post_id = $request->input('post_id');

        if(Auth::check()) {
            if(is_numeric((int)$post_id)) {
                $user_id =  Auth::user()->id;
                $existing_postmark = Postmark::where('user_id', $user_id)->where('post_id', $post_id)->first();

                if(!$existing_postmark) {
                    $postmark = new Postmark();
                    $postmark->post_id = $post_id;
                    $postmark->user_id = $user_id;
                    $postmark->save();
                    return response()->json('add');
                } else {
                    $existing_postmark->delete();
                    return response()->json('delete');
                }
            } else {
                return response()->json('error');
            }
        } else {
            return response()->json('user');
        }
    }

    public function thematiques()
    {
        $results = [];
        $thematiques = Thematique::all();
        $results['thematiques'] = $thematiques;
        $tools = Tool::where('status', 'publié')->where('published_at', '<', Carbon::yesterday())->get();
        $results['tools'] = $tools;
        $posts = Post::where('status', 'publié')->where('published_at', '<', Carbon::yesterday())->get();
        $results['posts'] = $posts;
        $convo = Conversation::where('created_at', '<', Carbon::yesterday())->get();
        $results['convo'] = $convo;
        echo json_encode($results);
    }

    public function profileInfos(Request $request)
    {
        $info = $request->input('info');
        $value = $request->input('value');
        $user = User::find(Auth::user()->id);

        if($value == 'true') {
            $value = true;
        } else {
            $value = false;
        }

        if($info == 'gender_show') {
            $user->gender_show = $value;
        } else if($info == 'title_show') {
            $user->title_show = $value;
        } else if($info == 'environment_show') {
            $user->environment_show = $value;
        } else if($info == 'birthdate_show') {
            $user->birthdate_show = $value;
        } else if($info == 'years_xp_show') {
            $user->years_xp_show = $value;
        } else {
            $user->work_city_show = $value;
        }
        
        $user->save();

        return response()->json($info);
    }

    public function thematiquesBookmarks(Request $request)
    {
        $theme_id = $request->input('theme_id');

        if(Auth::check() && Auth::user()->verified) {
            if(is_numeric((int)$theme_id)) {
                $user_id =  Auth::user()->id;
                $existing_bookmark = BookmarkThematiques::where('user_id', $user_id)->where('thematique_id', $theme_id)->first();

                if(!$existing_bookmark) {
                    $bookmark = new BookmarkThematiques();
                    $bookmark->thematique_id = $theme_id;
                    $bookmark->user_id = $user_id;
                    $bookmark->save();
                    return response()->json('add');
                } else {
                    $existing_bookmark->delete();
                    return response()->json('delete');
                }
            } else {
                return response()->json('error');
            }
        } else {
            return response()->json('user');
        }
    }

}
