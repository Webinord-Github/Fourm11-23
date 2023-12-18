<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvalidPasswordResetLinkController extends Controller
{
    public function index(){
        return view('frontend.invalid-token-reset');
    }
}
