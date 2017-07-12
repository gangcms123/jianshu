<?php

namespace App\Model;


class AdminPermission extends Model
{
    //权限属于那个角色
    public function roles()
    {
        return $this->belongsToMany(\App\Model\AdminRole::class,'admin_permission_role','permission_id','role_id')->withPivot(['permission_id','role_id']);
    }
}
