<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('photo');
            $table->string('emp_code');
            $table->string('emp_name');
            $table->string('gender');
            $table->date('dob');
            $table->date('doj');
            $table->date('prob_period');
            $table->date('doc');
            $table->string('email');
            $table->string('address');
            $table->string('mob_number');
            $table->string('emer_number');
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
        Schema::drop('employees');
    }
}
