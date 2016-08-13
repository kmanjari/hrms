<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('attendance_managers', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->date('date');
            $table->string('day');
            $table->time('in_time');
            $table->time('out_time');
            $table->string('hours_worked');
            $table->string('difference');
            $table->tinyInteger('status');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        //
    }
}
