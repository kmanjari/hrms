<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAndChangeColumnsOfEmployeeTable extends Migration
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
            if(\Schema::hasColumn('employees', 'start_probation'))
            {
                $table->dropColumn('start_probation');
            }
            if(\Schema::hasColumn('employees', 'end_probation'))
            {
                $table->dropColumn('end_probation');
            }
            if(\Schema::hasColumn('employees', 'mob_number'))
            {
                $table->dropColumn('mob_number');
            }
            if(\Schema::hasColumn('employees', 'emer_number'))
            {
                $table->dropColumn('emer_number');
            }
            if(\Schema::hasColumn('employees', 'address'))
            {
                $table->dropColumn('address');
            }
            if(\Schema::hasColumn('employees', 'doc'))
            {
                $table->dropColumn('doc');
            }
            if(!Schema::hasColumn('employees', 'mob_number'))
            {
                $table->string('mob_number')->after('doj');
            }
            if(!Schema::hasColumn('employees', 'qualification'))
            {
                $table->string('qualification')->after('mob_number');
            }
            if(!Schema::hasColumn('employees', 'emer_number'))
            {
                $table->string('emer_number')->after('qualification');
            }
            if(!Schema::hasColumn('employees', 'pan_number'))
            {
                $table->string('pan_number')->after('emer_number');
            }
            if(!Schema::hasColumn('employees', 'father_name'))
            {
                $table->string('father_name')->after('pan_number');
            }
            if(!Schema::hasColumn('employees', 'address'))
            {
                $table->string('address')->after('father_name');
            }
            if(!Schema::hasColumn('employees', 'permanent_address'))
            {
                $table->string('permanent_address')->after('address');
            }
            if(!Schema::hasColumn('employees', 'formalities'))
            {
                $table->string('formalities')->after('permanent_address');
            }
            if(!Schema::hasColumn('employees', 'offer_acceptance'))
            {
                $table->string('offer_acceptance')->after('permanent_address');
            }
            if(!Schema::hasColumn('employees', 'prob_period'))
            {
                $table->string('prob_period')->after('offer_acceptance');
            }
            if(!Schema::hasColumn('employees', 'doc'))
            {
                $table->date('doc')->after('prob_period');
            }
            if(!Schema::hasColumn('employees', 'department'))
            {
                $table->string('department')->after('doc');
            }
            if(!Schema::hasColumn('employees', 'salary'))
            {
                $table->string('salary')->after('department');
            }
            if(!Schema::hasColumn('employees', 'account_number'))
            {
                $table->string('account_number')->after('salary');
            }
            if(!Schema::hasColumn('employees', 'bank_name'))
            {
                $table->string('bank_name')->after('account_number');
            }
            if(!Schema::hasColumn('employees', 'ifsc_code'))
            {
                $table->string('ifsc_code')->after('bank_name');
            }
            if(!Schema::hasColumn('employees', 'pf_account_number'))
            {
                $table->string('pf_account_number')->after('ifsc_code');
            }
            if(!Schema::hasColumn('employees', 'pf_status'))
            {
                $table->string('pf_status')->after('pf_account_number');
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
