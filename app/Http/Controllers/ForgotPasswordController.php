<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user == null) return redirect()->back()->with('message', 'User not found')->with('status', 'danger');

        Mail::to($user->email)->send(new ForgotPasswordMail($user));
        return redirect()->back()->with('message', 'Change Password Link Send Your Email')->with('status', 'success');
    }

    public function forgotPasswordGet($email, $email_token)
    {
        $user = User::where('email', $email)->where('email_token', $email_token)->first();
        if ($user == null) return redirect()->back()->with('message', 'unexpected error occurred')->with('status', 'danger');

        $user->email_token = Str::random(60);
        $user->save();
        return view('admin.authentication.forgot-password-change')->with('user', $user);
    }

    public function changePassword($email, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'min:8|required|max:255|email',
            'password' => ['required',
                'min:6',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
            'repassword' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')->with('message', 'Password change processing is failed')->with('status', 'danger');
        } else {
            $user = User::where('email', $email)->first();

            if ($user == null) {
                return redirect()->route('login')->with('message', 'Password change processing is failed')->with('status', 'danger');
            }
            else {
                $user->password = bcrypt($request->password);
                $user->update();

                return redirect()->route('login')->with('message', 'Accound password changed')->with('status', 'success');
            }
        }
    }
}
