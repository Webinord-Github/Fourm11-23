<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\User;
use Auth;
use Carbon\Carbon;

class RepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $reply = Auth::user()->replies()->save(new Reply($request->only([
            'body', 'conversation_id'
        ])));
        $formattedCreatedAt = Carbon::parse($reply->created_at)->format('Y-m-d H:i:s');

        return response()->json([
            'message' => 'Reply created successfully',
            'body' => $reply->body,
            'name' => auth()->user()->name,
            'created_at' => $formattedCreatedAt,
            'id' => $reply->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $replyId = $request->input('reply_id');
        
        // Logic to find and delete the reply
        $reply = Reply::find($replyId);
        if (!$reply) {
            return response()->json(['error' => 'Reply not found'], 404);
        }
    
        // Perform the deletion
        $reply->delete();
    
        return response()->json(['message' => 'Reply deleted successfully'], 200);
    }
    
}
