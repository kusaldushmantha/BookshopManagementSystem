<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['firstname','lastname','username','password','contactno','accesslevel'];

    protected $hidden = ['password','remember_token'];
}
