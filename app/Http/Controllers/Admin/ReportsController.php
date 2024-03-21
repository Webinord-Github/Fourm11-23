<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Signalement;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\AutoEmail;
use App\Models\AutomaticEmail;


class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Signalement::orderBy('created_at', 'desc')->get();   
        return view('admin.reports.index')->with(['reports' =>  $reports]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Signalement  $signalement
     * @return \Illuminate\Http\Response
     */
    public function show(Signalement $signalement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Signalement  $signalement
     * @return \Illuminate\Http\Response
     */
    public function edit(Signalement $signalement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Signalement  $signalement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Signalement $signalement)
    {
        $signalement->fixed = true;
        $signalement->save();
        return back()->with('status', 'Le signalement a été résolu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Signalement  $signalement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Signalement $signalement)
    {
        //
    }

    public function deletedReply(Request $request, Signalement $signalement)
    {  
        $reportTarget = Signalement::where('id', $signalement->id)->first();
    
        $userTarget = User::where('id', $reportTarget->reported_author_user_id)->first();
        $userEmail = $userTarget->email;
        $userFirstName = $userTarget->firstname;
        $signalement->fixed = true;
        $signalement->save();

        $to_email = $userEmail;
        $automaticEmail = AutomaticEmail::where('id', 5)->first();
        $emailBody = "<h1 style='text-align:center;'>Commentaire Supprimé</h1><p>Bojour <strong>$userFirstName</strong>,</p>" . $automaticEmail->content;
        $customSubject = 'Courriel de la fourmilière';
        Mail::to($to_email)->send(new AutoEmail($emailBody, $customSubject));
        return back()->with('status', 'Le signalement a été résolu');

    }
}
