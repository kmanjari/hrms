<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingAttendees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_attendees', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('meeting_id')->unsigned();
            $table->integer('attendee_id')->unsigned();
            $table->foreign('meeting_id')->references('id')->on('meetings')->onDelete('cascade');
            $table->foreign('attendee_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });


    }/**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('meeting_attendees');
    }
}
