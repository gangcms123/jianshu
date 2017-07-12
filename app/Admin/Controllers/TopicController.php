<?php
namespace App\Admin\Controllers;
use App\Model\Topic;

class TopicController extends Controller
{
    //专题列表页面
    public function index()
    {
        $topics = Topic::all();
        return view('admin.topic.index',compact('topics'));
    }

    //专题创建页面
    public function create()
    {
        return view('admin.topic.add');
    }

    //专题保存操作
    public function store()
    {
        $this->validate(request(),[
            'name' => 'required|string',
        ]);

        Topic::create(['name'=>request('name')]);

        return redirect('/admin/topics');

    }

    //删除专题
    public function destroy(Topic $topic)
    {
        $topic->delete();
        return [
            'error' => 0,
            'message' => ''
        ];
    }
}