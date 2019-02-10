<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('first_user_id')->unsigned();
            $table->integer('second_user_id')->unsigned();
            $table->integer('league_id')->unsigned();
            $table->integer('first_user_goal');
            $table->integer('second_user_goal');
            $table->float('first_user_previous_score', 8, 2);	
            $table->float('second_user_previous_score', 8, 2);	
            $table->float('score_change', 8, 2);
            $table->foreign('first_user_id')->references('id')->on('users');
            $table->foreign('second_user_id')->references('id')->on('users');
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
        Schema::dropIfExists('matches');
    }
}
