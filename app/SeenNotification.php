<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeenNotification extends Model
{
    protected $table = 'seen_notification';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
