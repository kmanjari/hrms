<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEmployeeTableAddFkToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function(Blueprint $table)
        {
           if(!Schema::hasColumn('user_id', 'employees'))
           {
               $table->integer('user_id')->after('full_final')->unsigned();
               $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
           }
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
