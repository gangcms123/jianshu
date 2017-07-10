<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Topic;

class TopicController extends Controller
{
    public function show(Topic $topic)
    {
        //获取带文章数的专题
        $topic = Topic::withCount('postTopics')->find($topic->id);
        //获得当前专题的文章列表，倒叙排列
        $posts = $topic->posts()->orderBy('created_at','desc')->take(10)->get();
        //获得属于我的文章（不是当前专题的）
        $myposts = \App\Model\Post::authBy(\Auth::id())->topicNotBy($topic->id)->get();
        return view('topic/show',compact('topic','posts','myposts'));
    }

    public function submit(Topic $topic)
    {
        $this->validate(request(),[
            'post_ids' => 'required|array',
        ]);
        $post_ids = request('post_ids');
        $topic_id = $topic->id;
        foreach ($post_ids as $post_id){
            \App\Model\PostTopic::firstOrCreate(compact('topic_id','post_id'));
        }
        return back();
    }
}
