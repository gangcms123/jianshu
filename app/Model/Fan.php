<?php

namespace App\Model;

use App\Model\Model;

class Fan extends Model
{
    //获粉丝用户
    public function fuser()
    {
        return $this->hasOne('App\Model\User','id','fan_id');
    }

    //获明星用户
    public function suser()
    {
        return $this->hasOne('App\Model\User','id','star_id');
    }

}
