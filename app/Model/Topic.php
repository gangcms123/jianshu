<?php

namespace App\model;
use App\Model\Model;

class Topic extends Model
{
    //属于这个专题的所有文章
    public function posts()
    {
        return $this->belongsToMany('App\Model\Post','post_topics','topic_id','post_id');
    }

    //专题的文章数
    public function postTopics()
    {
        return $this->hasMany('App\Model\PostTopic','topic_id');
    }
}
