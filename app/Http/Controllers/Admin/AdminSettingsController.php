<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MailSetting;
use App\Models\Maintenance;
use Illuminate\Support\Facades\Artisan;
use Auth;
use App\Events\MaintenanceModeUpdated;
use App\Models\Cookie;

class AdminSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mailSetting = MailSetting::first();
        $maintenance = Maintenance::first();
        $cookie = Cookie::first();

        return view('admin.settings.index', compact('mailSetting', 'maintenance', 'cookie'));
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
        $validatedData = $request->validate([
            'host' => ['required', 'string', 'max:255'],
            'port' => ['required', 'numeric'],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'encryption' => ['required', 'string', 'max:255'],
 
        ], [
            'host.required' => 'Le champs est requis',
            'port.required' => 'Le champs est requis',
            'username.required' => 'Le champs est requis',
            'password.required' => 'Le champs est requis',
            'encryption.required' => 'Le champs est requis',

        ]);

        $existingmailSetting = MailSetting::where('id', 1)->first();
        if(!$existingmailSetting){
            $mailSetting = new MailSetting();
            $mailSetting->host = $validatedData['host'];
            $mailSetting->port = $validatedData['port'];
            $mailSetting->username = $validatedData['username'];
            $mailSetting->password = $validatedData['password'];
            $mailSetting->encryption = $validatedData['encryption'];
            $mailSetting->save();
        } else {
            $existingmailSetting->host = $validatedData['host'];
            $existingmailSetting->port = $validatedData['port'];
            $existingmailSetting->username = $validatedData['username'];
            $existingmailSetting->password = $validatedData['password'];
            $existingmailSetting->encryption = $validatedData['encryption'];
            $existingmailSetting->save();
        }

      
        return redirect()->route('parametres.index')->with('status', 'Opération réussie');

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function maintenanceMode(Request $request)
    {
        $maintenanceValue = $request->has('maintenance') ? 1 : 0;
        $existingMaintenance = Maintenance::where('id', 1)->first();
        if(!$existingMaintenance) {
            $maintenance = new Maintenance();
            $maintenance->maintenance = $maintenanceValue;
            $maintenance->save();
        } else {
            $existingMaintenance->maintenance = $maintenanceValue;
            $existingMaintenance->save();
        }
        if($maintenanceValue == 1) {
   
        } else {
         
        }
        return redirect()->route('parametres.index')->with('status', 'Site mis en maintenance.');
    }

    public function cookieScript(Request $request) 
    {   
        $cookie = $request->cookie;
        $existing = Cookie::first();
        $existing->cookie_script = $cookie;
        $existing->save();
        return redirect()->route('parametres.index')->with('status', 'Cookie sauvegardé');

    }
}
