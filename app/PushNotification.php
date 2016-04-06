<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    protected $table = 'devices';

    public $timestamps = false;
}
