<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFilenameTableAlterColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('filenames', function(Blueprint $table)
        {

            if(!Schema::hasColumn('filenames', 'name'))
            {
                $table->string('name')->after('id');
            }


            if(!Schema::hasColumn('filenames', 'description'))
            {
                $table->string('description')->after('name');
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
