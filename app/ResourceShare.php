<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceShare extends Model
{
    protected $table = 'resource_shares';

    protected $hidden = ['created_at','updated_at'];
}
