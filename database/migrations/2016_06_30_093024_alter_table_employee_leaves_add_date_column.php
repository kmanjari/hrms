<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEmployeeLeavesAddDateColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('employee_leaves', function(Blueprint $table)
        {
            if(!Schema::hasColumn('employee_leaves', 'date_from'))
            {
                $table->date('date_from')->after('leave_type_id');
            }

            if(!Schema::hasColumn('employee_leaves', 'date_to'))
            {
                $table->date('date_to')->after('date_from');
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
