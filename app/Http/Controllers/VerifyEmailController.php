<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class VerifyEmailController extends Controller
{
    public function activate($name, $token)
    {
        $user = User::where('name', $name)->where('email_token', $token)->firstOrFail();

        if ($user->verified != true) {
            $user->verified = true;
            $user->email_verified_at = Carbon::now();
            $user->save();
            return redirect()->route('login')->with('message', 'Email address verified successfull')->with('status', 'success');
        }

        return redirect()->route('login')->with('message', 'Already verified email address');
    }
}
