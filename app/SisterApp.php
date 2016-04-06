<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SisterApp extends Model
{
    protected $table = 'sister_apps';

    protected $hidden = ['created_at','updated_at'];
}
