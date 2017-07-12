<?php
namespace App\Admin\Controllers;
use App\Model\AdminUser;
use App\Model\AdminRole;

class RoleController extends Controller
{
    //角色列表页面
    public function index()
    {
        $roles = AdminRole::paginate(10);
        return view('admin.role.index',compact('roles'));
    }

    //添加角色页面
    public function create()
    {
        return view('admin.role.add');
    }

    //添加角色操作
    public function store()
    {
        $this->validate(request(),[
            'name' => 'required|min:3',
            'description' => 'required',
        ]);
        AdminRole::create(request(['name','description']));
        return redirect('/admin/roles');
    }

    //角色的权限关系页面
    public function permission(AdminRole $role)
    {
        //获取所有权限
        $permissions = \App\Model\AdminPermission::all();

        //获得当前角色权限
        $mypermissions = $role->permissions;

        return view('admin.role.permission',compact('permissions','mypermissions','role'));
    }

    //添加角色的权限
    public function storePermission(AdminRole $role)
    {
        $this->validate(request(),[
            'permissions.*' => 'required|integer',
        ]);

        $permissions = \App\Model\AdminPermission::findMany(request('permissions'));
        $mypermissions = $role->permissions;

        //要添加的权限
        $addpremission = $permissions->diff($mypermissions);
        foreach ($addpremission as $permission)
        {
            $role->grantPermission($permission);
        }

        //要删除的权限
        $deletepermission = $mypermissions->diff($permissions);
        foreach ($deletepermission as $permission)
        {
            $role->deletePermission($permission);
        }

        return back();
    }
}