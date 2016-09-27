<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_leaves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('tl_id')->unsigned();
            $table->integer('manager_id')->unsigned();
            $table->integer('leave_type_id')->unsigned();
            $table->date('date_from');
            $table->date('date_to');
            $table->time('from_time');
            $table->time('to_time');
            $table->string('days');
            $table->tinyInteger('status')->default(0)->comment('0 = Unapproved, 1 = Approved');
            $table->string('remarks');
            $table->string('reason');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade');
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
        Schema::drop('employee_leaves');
    }
}
