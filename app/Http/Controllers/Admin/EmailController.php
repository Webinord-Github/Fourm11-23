<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

class EmailController extends Controller
{

    public function index() {
        return view('emails.test');
    }
    public function sendEmail(Request $request)
    {
        // Check if the request is a POST request
        if ($request->isMethod('post')) {
            // Logic to send an email goes here
            $to_email = 'info@webinord.ca';
            $emailBody = "test";
            Mail::to($to_email)->send(new TestEmail($emailBody));
  
    
            return 'Email sent successfully';
        }
        // If the request method is not POST, return a message or redirect back
        return 'Form not submitted';
    }
    
}
