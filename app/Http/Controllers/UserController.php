<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //个人中心
    public function show(User $user)
    {
        //获得当前用户信息 /关注/粉丝/文章 数量
        $user = User::withCount(['stars','fans','posts'])->find($user->id);
        //获取当前用户的文章前十条
        $posts = $user->posts()->with('user')->orderBy('created_at','desc')->take(10)->get();
        //获取当前用户的粉丝用户和他的 /关注/粉丝/文章 数量
        $fans = $user->fans;
        $fusers = User::whereIn('id',$fans->pluck('fan_id'))->withCount(['stars','fans','posts'])->get();
        //获取当前用户关注的用户的 /关注/粉丝/文章 数量
        $stars = $user->stars;
        $susers = User::whereIn('id',$stars->pluck('fan_id'))->withCount(['stars','fans','posts'])->get();
        return view('user.show',compact('user','posts','fusers','susers'));
    }

    //关注用户
    public function fan(User $user)
    {
        Auth::user()->doFan($user->id);
        return [
            'error' => 0
        ];
    }

    //取消关注
    public function unfan(User $user)
    {
        Auth::user()->doUnFan($user->id);
        return [
            'error' => 0
        ];
    }

    //个人设置行为
    public function settingStore()
    {

    }
}
