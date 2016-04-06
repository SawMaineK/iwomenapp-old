<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TLGMember extends Model
{
    protected $table = 'tlg_member';

    protected $hidden = ['created_at','updated_at'];
}
