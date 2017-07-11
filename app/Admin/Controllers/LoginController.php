<?php
namespace App\Admin\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //登录页面
    public function index()
    {
        return view('admin.login.index');
    }

    //登录操作
    public function login(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|min:4',
            'password' => 'required|min:6|max:10',
        ]);

        $logindata = [
            'name' => $request->name,
            'password' => $request->password,
        ];
        if(Auth::guard('admin')->attempt($logindata)){
            return redirect('/admin/home');
        }
        return redirect()->back()->withErrors('用户名密码不匹配');
    }

    //退出登录
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}