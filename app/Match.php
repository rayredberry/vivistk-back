<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    //
    protected $fillable = [
        'first_user_id', 'second_user_id', 'league_id', 'first_user_goal', 'second_user_goal', 'first_user_previous_score', 'second_user_previous_score', 'score_change'
    ];

}
