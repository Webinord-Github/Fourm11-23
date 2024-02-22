<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Signet;
use App\Models\Tool;
use Carbon\Carbon;
use Auth;

class SignetsController extends Controller
{
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

    public function tools()
    {
        $tools = Tool::where('status', 'publié')->where('published_at', '>', Carbon::yesterday())->get();

        echo json_encode($tools);
    }
}
