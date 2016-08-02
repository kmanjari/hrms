<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        \Schema::table('employees', function(Blueprint $table) {


            if(!Schema::hasColumn('employees', 'mob_number'))
            {
                $table->string('mob_number')->after('doj');
            }
            if(!Schema::hasColumn('employees', 'emer_number'))
            {
                $table->string('emer_number')->after('qualification');
            }
            if(!Schema::hasColumn('employees', 'address'))
            {
                $table->string('address')->after('father_name');
            }
            if(!Schema::hasColumn('employees', 'doc'))
            {
                $table->date('doc')->after('prob_period');
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
