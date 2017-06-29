<?php

namespace App\Model;

class Post extends Model
{
    //一篇文章属于一个用户
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    //一篇文章有多个评论
    public function comments()
    {
        return $this->hasMany('App\Model\Comment')->orderBy('created_at','desc');
    }

    //文章下该用户是否已经点赞
    public function zan($user_id)
    {
        return $this->hasOne('App\Model\Zan')->where('user_id',$user_id);
    }

    //获得当前文章的所有赞
    public function zans()
    {
        return $this->hasMany('App\Model\Zan');
    }
}
