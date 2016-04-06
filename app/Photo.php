<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'images';

    protected $hidden = ['id','post_id','created_at','updated_at'];
}
