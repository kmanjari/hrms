<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEmployeeLeaveTableAddTlAndManager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_leaves', function (Blueprint $table) {
            if (!Schema::hasColumn('tl_id', 'employee_leaves')) {
                $table->integer('tl_id')->unsigned()->after('employee_id');
            }

            if (!Schema::hasColumn('manager_id', 'employee_leaves')) {
                $table->integer('manager_id')->unsigned()->after('tl_id');
            }

            if (!Schema::hasColumn('from_time', 'employee_leaves')) {
                $table->time('from_time')->after('date_to');
            }

            if (!Schema::hasColumn('to_time', 'employee_leaves')) {
                $table->time('to_time')->after('from_time');
            }

            if (!Schema::hasColumn('days', 'employee_leaves')) {
                $table->string('days')->after('to_time');
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
