<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    //

    protected $fillable = [
        'user_id', 'league_id', 'games', 'win', 'draw', 'lose', 'goals_for', 'goals_against', 'max_score', 'min_score', 'score', 'streak'
    ];



}
