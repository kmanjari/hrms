<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEmployeesTableAddStartAndEndProbationDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('employees', function(Blueprint $table)
        {
            if(\Schema::hasColumn('employees', 'prob_period'))
            {
                $table->dropColumn('prob_period');
            }

            if(!Schema::hasColumn('employees', 'start_probation'))
            {
                $table->date('start_probation')->after('doj');
            }

            if(!Schema::hasColumn('employees', 'end_probation'))
            {
                $table->date('end_probation')->after('start_probation');
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
