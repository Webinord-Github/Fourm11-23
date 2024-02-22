<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;
use App\Models\Chat;
use Auth;
use Carbon\Carbon;

class UsersController extends Controller
{

    public function __construct() {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  
    public function index()
    {     
        return view('admin.users.index', [
            'model' => User::all(),
            'authuser' => Auth::user()->id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create')->with([
            'model' => new User(),
            'roles' => Role::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateUserRequest $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'firstname' => $request->name,
            'email' => $request->email,
            'verified' => true,
            'password' => Hash::make($request->password),
            'image' => null,
        ]);



        $user->roles()->sync($request->roles);

        return redirect()->route('users.index')->with('status', "User: $user->name was created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $userÈ
     */
    public function show(User $user)
    {
        return view('frontend.profil', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
      
        return view('admin.users.edit', [
            'model' => $user,
            'roles' => Role::all(),
            'authuser' => Auth::user()->id,
            'authUserIsSuperAdmin' => Auth::user()->hasRole('Super Admin'),
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {        
        if(Auth::user()->id == $user->id && Auth::user()->hasRole('Super Admin')) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            $user = User::findOrFail($user->id); // Fetch the user model
            $user->verified = $request->has('checkbox') ? true : false;
            $user->save();
    
            $user->roles()->sync(1);
            return back()->with('status', 'user-updated');
        }
        
        else {
            $request->validate([
                'roles' => 'required'
            ]);
            
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $user = User::findOrFail($user->id); // Fetch the user model
            $user->verified = $request->has('checkbox') ? true : false;
            $user->save();
            
            $user->roles()->sync($request->roles);
            
            return back()->with('status', 'user-updated');
        }
    }

    public function updateUserPassword(Request $request, User $user)
    {

        if(Auth::user()->id != $user->id && Auth::user()->hasRole('Super Admin')) {   
            $validated = $request->validateWithBag('updatePassword', [
                'password' => ['required', Password::defaults(), 'confirmed'],
            ]);
        }
        else {
            $validated = $request->validateWithBag('updatePassword', [
                'current_password' => ['required', 'current_password'],
                'password' => ['required', Password::defaults(), 'confirmed'],
            ]);
        }
            
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        
        return back()->with('status', 'updated-password');
   
            
        
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('status', "$user->name was delete.");
    }  

    
}
