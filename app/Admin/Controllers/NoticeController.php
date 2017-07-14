<?php
namespace App\Admin\Controllers;
use App\Model\Notice;

class NoticeController extends Controller
{
    //专题列表页面
    public function index()
    {
        $notices = Notice::all();
        return view('admin.notice.index',compact('notices'));
    }

    //专题创建页面
    public function create()
    {
        return view('admin.notice.add');
    }

    //专题保存操作   nohup php artisan queue:work >> /dev/null & 保持这个队列一直运行

    public function store()
    {
        $this->validate(request(),[
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $notice = Notice::create(request(['title','content']));
        //分发通知任务到队列中
        dispatch(new \App\Jobs\SendNoticeMessage($notice));

        return redirect('/admin/notices');

    }

}