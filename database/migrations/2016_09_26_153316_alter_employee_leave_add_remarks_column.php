<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEmployeeLeaveAddRemarksColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('employee_leaves' , function(Blueprint $table)
        {
            if(!\Schema::hasColumn('remarks','employee_leaves'))
            {
                $table->string('remarks')->after('status');
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
