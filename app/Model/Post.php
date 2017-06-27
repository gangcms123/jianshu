<?php

namespace App\Model;

class Post extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
}
