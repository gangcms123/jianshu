<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    //可以注入的字段
    protected $fillable = [
        'title', 'content',
    ];
}
