<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTraininginviteAddInviteId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('training_invites' , function(Blueprint $table)
        {
            if(!\Schema::hasColumn('invite_id','training_invites'))
            {
                $table->integer('invite_id')->after('user_id');
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
