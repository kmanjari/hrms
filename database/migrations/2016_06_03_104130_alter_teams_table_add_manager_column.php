<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTeamsTableAddManagerColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('teams', function (Blueprint $table) {
            if (\Schema::hasColumn('teams', 'members')) {
                $table->dropColumn('members');
            }
        });

        \Schema::table('teams', function (Blueprint $table) {

            if (!\Schema::hasColumn('teams', 'manager_id')) {
                $table->integer('manager_id')->unsigned()->after('name');
            }

            if (!\Schema::hasColumn('teams', 'leader_id')) {
                $table->integer('leader_id')->unsigned()->after('manager_id');
            }

            if (!\Schema::hasColumn('teams', 'member_id')) {
                $table->integer('member_id')->unsigned()->after('leader_id');
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
