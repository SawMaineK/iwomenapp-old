<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apk extends Model
{
    protected $table = 'apps';
    
    protected $hidden = ['updated_at'];

}
