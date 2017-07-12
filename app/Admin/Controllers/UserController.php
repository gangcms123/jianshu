<?php
namespace App\Admin\Controllers;
use App\Model\AdminUser;

class UserController extends Controller
{
    //管理员列表页面
    public function index()
    {
        $users = AdminUser::paginate(10);
        return view('admin.user.index',compact('users'));
    }

    //管理员创建页面
    public function create()
    {
        return view('admin.user.add');
    }

    //管理员创建操作
    public function store()
    {
        $this->validate(request(),[
            'name' => 'required|min:3',
            'password' => 'required|min:6',
        ]);

        AdminUser::create([
            'name' => request('name'),
            'password' => bcrypt(request('password')),
        ]);

        return redirect('/admin/users');
    }

    //用户的角色页面
    public function role(AdminUser $user)
    {
        $myroles = $user->roles;
        $roles = \App\Model\AdminRole::all();
        return view('admin.user.role',compact('myroles','roles','user'));
    }

    //添加用户的角色
    public function storeRole(AdminUser $user)
    {
        $this->validate(request(),[
            'roles.*' => 'required|integer',
        ]);

        $roles = \App\Model\AdminRole::findMany(request('roles'));
        $myroles = $user->roles;

        //要添加的角色
        $addroles = $roles->diff($myroles);
        foreach ($addroles as $role)
        {
            $user->assignRole($role);
        }

        //要删除的角色
        $deleteroles = $myroles->diff($roles);
        foreach ($deleteroles as $role)
        {
            $user->deleteRole($role);
        }

        return back();
    }
}