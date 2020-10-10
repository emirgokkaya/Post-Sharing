<?php

namespace App\Http\Controllers;

use App\Mail\VerifyMail;
use App\User;
use App\VerifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Rules\Captcha;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index()
    {
        return view('admin.authentication.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'name' => 'min:3|required',
                'email' => 'min:8|unique:users|required|max:255|email',
                'password' => ['required',
                                'min:6',
                                'regex:/[a-z]/',
                                'regex:/[A-Z]/',
                                'regex:/[0-9]/',
                                'regex:/[@$!%*#?&]/'
                ],
                'repassword' => 'required|same:password',
                'g-recaptcha-response' => new Captcha(),
                'iAgree' => 'accepted'
        ]);

        if ($validator->fails()) {
            return redirect('/register')
                ->withErrors($validator)
                ->withInput();
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = "editor";
            $user->avatar = asset('assets/images/users/8.jpg');
            $user->password = bcrypt($request->password);
            $user->state = 1;
            $user->email_token = Str::random(60);
            $user->save();

            try {
                Mail::to($user->email)->send(new VerifyMail($user->name, $user->email_token));
            } catch (\Exception $exception) {
                return redirect()->route('login')->with('message', 'Your registration is completed, but there was an error sending your confirmation email, the confirmation email will be sent again when you log in.')->with('status', 'info');
            }

            return redirect()->route('login')->with('message', 'A link has been sent to confirm your e-mail address')->with('status', 'success');
        }
    }
}

// Enumerator
/*class UserRole {
    const Admin = "admin";
    const SuperAdmin = "super_admin";
    const Member = "member";
}*/
