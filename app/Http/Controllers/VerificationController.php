<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend'); //6 per min
    }

    public function notice(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect('/dashboard') : view('users.verify-email');
    }

    public function verify(EmailVerificationRequest  $request){
        $request->fulfill();
        return redirect('/dashboard');
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()
        ->withSuccess('Um novo token foi enviado para seu e-mail.');
    }


  
}
