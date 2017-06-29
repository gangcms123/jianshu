<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Post;

use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //文章列表
    public function index(){
        $posts = Post::orderBy('created_at','desc')->withCount('comments')->paginate(6);
        return view('post/index',compact('posts'));
    }

    //文章详情
    public function show(Post $post){
        $post->load('comments.user');
        return view('post/show',compact('post'));
    }

    //创建文章页面
    public function create(){
        return view('post/create');
    }

    //添加文章
    public function store(){
        $this->validate(request(),[
            'title' => 'required|string|max:100|min:5',
            'content' => 'required|string|min:10',
        ]);
        $user_id = Auth::id();
        $data = array_merge(request(['title','content']),compact('user_id'));
        $post = Post::create($data);
        return redirect(route('index'));
    }

    //编辑文章页面
    public function edit(Post $post){
        return view('post/edit',compact('post'));
    }

    //更新文章
    public function update(Post $post){
        $this->validate(request(),[
            'title' => 'required|string|max:100|min:5',
            'content' => 'required|string|min:10',
        ]);
        $this->authorize('update',$post);
       $post->title = request('title');
       $post->content = request('content');
       $post->save();
       return redirect(route('show',['id'=>$post->id]));
    }

    //删除文章
    public function delete(Post $post){
        $this->authorize('delete',$post);
        $post->delete();
        return redirect(route('index'));
    }

    //图片上传
    public function imageUpload(Request $request){
       $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
       return asset('storage/'.$path);
    }

    //提交评论
    public function comment(Post $post){
        $this->validate(request(),[
            'content' => 'required|string|min:5',
        ]);
        $user_id = Auth::id();
        $content = request('content');
        $post->comments()->create(compact('user_id','content'));
        return back();
    }
}
