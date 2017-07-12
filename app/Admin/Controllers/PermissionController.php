<?php
namespace App\Admin\Controllers;
use App\Model\AdminPermission;

class PermissionController extends Controller
{
    //权限列表页面
    public function index()
    {
        $permissions = AdminPermission::paginate(10);
        return view('admin.permission.index',compact('permissions'));
    }

    //添加权限页面
    public function create()
    {
        return view('admin.permission.add');
    }

    //添加权限操作
    public function store()
    {
        $this->validate(request(),[
            'name' => 'required|min:3',
            'description' => 'required',
        ]);
        AdminPermission::create(request(['name','description']));
        return redirect('/admin/permissions');
    }
}