<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
	use SoftDeletes;
    protected $table = 'posts';
    protected $dates = ['deleted_at'];
    protected $hidden = ['updated_at','deleted_at'];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function contents()
    {
        return $this->hasMany('App\Content');
    }

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public function author()
    {
        return $this->belongsTo('App\Author');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function audio()
    {
        return $this->hasOne('App\Audio');
    }

    public function video()
    {
        return $this->hasOne('App\Video');
    }


}
