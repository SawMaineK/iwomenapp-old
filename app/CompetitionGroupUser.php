<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionGroupUser extends Model
{
    protected $table = 'competition_group_users';

    public function answer()
    {
        return $this->hasMany('App\CompetitionAnswer', 'competition_group_user_id');
    }
}
