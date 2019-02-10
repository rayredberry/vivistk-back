<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeagueUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('league_id')->unsigned();
            $table->integer('games')->default(0);
            $table->integer('win')->default(0);
            $table->integer('draw')->default(0);
            $table->integer("goals_for")->default(0);
            $table->integer('goals_against')->default(0);
            $table->float('max_score', 8, 2)->default(40);
            $table->float('min_score', 8, 2)->default(40);
            $table->float('score', 8, 2)->default(40);
            $table->integer('streak')->default(40);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('league_id')->references('id')->on('leagues');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('league_user');
    }
}
