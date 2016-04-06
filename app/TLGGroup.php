<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TLGGroup extends Model
{
    protected $table = 'tlg_groups';

    protected $hidden = ['created_at','updated_at'];
}
