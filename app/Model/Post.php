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
}
