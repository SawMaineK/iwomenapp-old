<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourcePost extends Model
{
	use SoftDeletes;
    protected $table = 'resource_posts';
    protected $dates = ['deleted_at'];
    protected $hidden = ['updated_at','deleted_at'];

    public function share()
    {
        return $this->hasMany('App\ResourceShare');
    }

    public function photos()
    {
        return $this->hasMany('App\ResourcePhoto');
    }

    public function author()
    {
        return $this->belongsTo('App\Author');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function resource_category()
    {
        return $this->belongsTo('App\ResourceCategory');
    }


}
