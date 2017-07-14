<?php

namespace App\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //可以注入的字段
    protected $fillable = [
        'name', 'email','password'
    ];

    //获取用户的文章列表
    public function posts()
    {
        return $this->hasMany('App\Model\Post','user_id','id');
    }

    //关注我的
    public function fans()
    {
        return $this->hasMany('App\Model\Fan','star_id','id');
    }

    //我关注的
    public function stars()
    {
        return $this->hasMany('App\Model\Fan','fan_id','id');
    }

    //关注别人
    public function doFan($uid)
    {
        $fan = new \App\Model\Fan();
        $fan->star_id = $uid;
        return $this->stars()->save($fan);

    }

    //取消关注
    public function doUnFan($uid)
    {
        $fan = new \App\Model\Fan();
        $fan->star_id = $uid;
        return $this->stars()->delete($fan);

    }

    //当前用户是否被uid关注
    public function hasFan($uid)
    {
        return $this->fans()->where('fan_id',$uid)->count();
    }

    //当前用户是否关注了uid
    public function hasStar($uid)
    {
        return $this->stars()->where('star_id',$uid)->count();
    }

    //用户收到的通知
    public function notices()
    {
        return $this->belongsToMany(\App\Model\Notice::class,'user_notice','user_id','notice_id')->withPivot(['user_id','notice_id']);
    }

    //添加通知
    public function addNotice($notice)
    {
        return $this->notices()->save($notice);
    }

    //删除通知
    public function deleteNotice($notice)
    {
        return $this->notices()->detach($notice);
    }

}
