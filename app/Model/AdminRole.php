<?php

namespace App\Model;


class AdminRole extends Model
{
    //当前角色的所有权限
    public function permissions()
    {
        return $this->belongsToMany(\App\Model\AdminPermission::class,'admin_permission_role','role_id','permission_id')->withPivot(['role_id','permission_id']);
    }

    //给角色添加权限
    public function grantPermission($permission)
    {
        return $this->permissions()->save($permission);
    }

    //角色删除权限
    public function deletePermission($permission)
    {
        return $this->permissions()->detach($permission);
    }

    //判断角色是否拥有权限(判断一个集合里是否有某个对象)
    public function hasPermission($permission)
    {
        return $this->permissions->contains($permission);
    }
}
