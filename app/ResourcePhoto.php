<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourcePhoto extends Model
{
    protected $table = 'resource_images';

    protected $hidden = ['created_at','updated_at'];
}
