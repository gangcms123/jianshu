<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    //不可以注入的字段
    protected $guarded = [
        'id'
    ];
}
