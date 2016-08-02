<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrganiseColumnsOfEmployeeTable extends Migration
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
            $table->string('qualification')->after("mob_number");
            $table->string('emer_number')->after("qualification");
            $table->string('pan_number')->after("emer_number");
            $table->string('father_name')->after("pan_number");
            $table->string('address')->after("father_name");
            $table->string('permanent_address')->after("address");
            $table->string('formalities')->after("permanent_address");
            $table->string('offer_acceptance')->after("formalities");
            $table->string('prob_period')->after("offer_acceptance");
            $table->string('doc')->after("prob_period");
            $table->string('department')->after("doc");
            $table->string('salary')->after("department");
            $table->string('account_number')->after("salary");
            $table->string('bank_name')->after("account_number");
            $table->string('ifsc_code')->after("bank_name");
            $table->string('pf_account_number')->after("ifsc_code");
            $table->string('pf_status')->after("pf_account_number");
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
