<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceCategory extends Model
{
    protected $table = 'resource_categories';

    protected $hidden = ['created_at','updated_at'];
}
