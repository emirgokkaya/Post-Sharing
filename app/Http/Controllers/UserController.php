<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('email', '!=', auth()->user()->email)->get();

        return view('admin.pages.users.index')->with('users', $users);
    }

    public function show($name, $email, $id)
    {
        $user = User::where('name', $name)->where('email', $email)->where('id', $id)->firstOrFail();
        return view('admin.pages.users.edit')->with('user', $user);
    }

    public function update(Request $request, $name, $email, $id)
    {
        $validate = Validator::make($request->all(), [
            'user_role' => 'required',
            'state' => 'required',
        ]);

        if ($validate->fails()) return redirect()->back()->withErrors($validate);

        if ($request->user_role === "admin" || $request->user_role === "member" || $request->user_role === "editor"){
            if ($request->state != null) {
                $user = User::where('name', $name)->where('email', $email)->where('id', $id)->firstOrFail();
                $user->state = $request->state == 'active' ? true : false ;
                $user->role = $request->user_role;

                $user->update();
                return redirect()->back()->with('message', 'Kullanıcı durumu başarıyla güncellendi')->with('status', 'success');
            }
            return redirect()->back()->with('message', 'Kullanıcı durumu güncellenemedi')->with('status', 'warning');
        }
        else return redirect()->back()->with('message', 'Kullanıcı durumu güncellenemedi')->with('status', 'warning');
    }

    public function destroy($name, $email, $id)
    {
        User::whereId($id)->whereName($name)->whereEmail($email)->delete();

        return redirect()->back()->with('message', 'Kullanıcı silme işlemi başarılı')->with('status', 'info');
    }

    public function deleteAllUsers()
    {
        User::where('id', '!=', auth()->user()->id)->delete();

        return redirect()->back()->with('message', 'Tüm kullanıcılar silindi')->with('status', 'info');
    }
}
