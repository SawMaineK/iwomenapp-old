<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionQuestion extends Model
{
    protected $table = 'competition_questions';

    public function competitiongroupusers()
    {
    	return $this->hasMany('App\CompetitionGroupUser', 'competition_question_id');
    }
}
