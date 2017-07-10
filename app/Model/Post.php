<?php

namespace App\Model;
use App\Model\Model;
use Laravel\Scout\Searchable;
use PhpParser\Builder;

class Post extends Model
{
    use Searchable;

    //定义该模型索引的名字
    public function searchableAs()
    {
        return 'post';
    }

    //设置该模型被搜索的字段
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

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

    //获得某个用户的文章
    public function scopeAuthBy($query,$user_id)
    {
        return $query->where('user_id',$user_id);
    }

    public function postTopics()
    {
        return $this->hasMany('App\Model\PostTopic','post_id','id');
    }

    //不属于某个专题的文章
    public function scopeTopicNotBy($query,$topic_id)
    {
        return $query->doesntHave('postTopics','and',function ($q) use($topic_id){
            $q->where('topic_id',$topic_id);
        });
    }


}
