<?php

namespace App\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //可以注入的字段
    protected $fillable = [
        'name', 'email','password'
    ];
}
