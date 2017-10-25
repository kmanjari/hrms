<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAttendanceManagerAddOneField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('attendance_managers' , function(Blueprint $table)
        {
            if(!\Schema::hasColumn('leave_status','attendance_managers'))
            {
                $table->string('leave_status')->after('status');
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
