<?php

namespace App\Model;

use App\Model\Model;

class Comment extends Model
{
    //评论属于一个文章
    public function post()
    {
        return $this->belongsTo('App\Model\Post');
    }

    //评论属于一个用户
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
}
