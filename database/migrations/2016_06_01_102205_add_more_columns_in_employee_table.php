<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreColumnsInEmployeeTable extends Migration
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
            if(!Schema::hasColumn('employees', 'emp_status'))
            {
                $table->string('emp_status')->after('emp_name');
            }

            if(!Schema::hasColumn('employees', 'dor'))
            {
                $table->date('dor')->after('pf_status');
            }

            if(!Schema::hasColumn('employees', 'notice_period'))
            {
                $table->string('notice_period')->after('dor');
            }

            if(!Schema::hasColumn('employees', 'last_working_day'))
            {
                $table->date('last_working_day')->after('notice_period');
            }

            if(!Schema::hasColumn('employees', 'full_final'))
            {
                $table->string('full_final')->after('last_working_day');
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
