<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostNotification extends Model
{
    protected $table = 'post_notification';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function seen()
    {
        return $this->hasMany('App\SeenNotificaton');
    }
}
