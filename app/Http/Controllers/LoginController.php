<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //登录页面
    public function index()
    {
        return view('login.index');
    }

    //登录行为
    public function login(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|min:6|max:10',
            'is_remember' => 'integer',
        ]);

        $logindata = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if(Auth::attempt($logindata,$request->is_remember)){
            return redirect(route('index'));
        }
        return redirect()->back()->withErrors('邮箱密码不匹配');
    }

    //登出行为
    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
