<?php

namespace App\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Model\Model;

class AdminUser extends Authenticatable
{
    protected $rememberTokenName = '';
}
