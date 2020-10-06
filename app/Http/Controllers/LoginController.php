<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Mail\VerifyMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.authentication.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'min:8|max:255|required|email',
            'password' => 'required',
            'rememberMe' => 'boolean'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } else {

            $user = User::where('email', $request->email)->first();

            if ($user == null)
                return redirect()->route('login')->with('message', 'Not Found User')->with('status', 'warning');

            if ($user->verified == false || $user->verified == 0) {
                if ($user->state === 1) {
                    $this->changeUserEmailToken($user);
                    try {
                        Mail::to($user)->send(new VerifyMail($user->name, $user->email_token));
                    } catch (\Exception $exception) {
                        return redirect()->route('login')->with('message', 'E-mail sending failed, please try again.')->with('status', 'warning');
                    }
                    return redirect()->route('login')->with('message', 'Please check your mailbox to verify your email address')->with('status', 'warning');
                } else {
                    return redirect()->route('login')->with('message', 'Account Access Denied')->with('status', 'danger');
                }

            }

            if (Hash::check($request->password, $user->password, [])){
                Auth::login($user, $request->has('rememberMe'));
                if (\auth()->user()->role === "admin") return redirect()->route('dashboard');
                else if(\auth()->user()->role === "editor") return redirect()->route('myprofile');
                else if (\auth()->user()->role === "member") return redirect()->route('index');
                else { Auth::logout(); return redirect()->route('login')->with('message', 'Giriş yapabilmek için yetkiniz bulunmuyor. Lütfen yönetici ile iletişime geçin')->with('status', 'danger'); }
            } else {
                return redirect()->route('login')->with('message', 'Password wrong')->with('status', 'danger');
            }

        }
    }

    public function changeUserEmailToken($user)
    {
        $user->email_token = Str::random(60);
        $user->save();
    }



    public function logout()
    {
        Auth::user()->setRememberToken(null);
        Auth::user()->save();
        Auth::logout();
        return redirect()->back();
    }
}
