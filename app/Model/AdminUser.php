<?php

namespace App\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Model\Model;

class AdminUser extends Authenticatable
{
    protected $guarded = ['id'];
    protected $rememberTokenName = '';

    //用户有那些角色
    public function roles()
    {
        return $this->belongsToMany(\App\Model\AdminRole::class,'admin_role_user','user_id','role_id')->withPivot(['user_id','role_id']);
    }

    //判断用户是否有某个或某些角色  (判断两个数据集是否有集合)
    public function isInRoles($roles)
    {
        return !!$roles->intersect($this->roles)->count();
    }

    //给用户分配角色
    public function assignRole($role)
    {
        return $this->roles()->save($role);
    }

    //取消用户分配的角色
    public function deleteRole($role)
    {
        return $this->roles()->detach($role);
    }

    //用户是否有权限
    public function hasPermission($permission)
    {
        return $this->isInRoles($permission->roles);
    }

}
