<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionAnswer extends Model
{
    protected $table = 'competition_group_answers';

    public function competitiongroupuser(){
    	return $this->belongsTo('App\CompetitionGroupUser', 'competition_group_user_id');
    }
}
