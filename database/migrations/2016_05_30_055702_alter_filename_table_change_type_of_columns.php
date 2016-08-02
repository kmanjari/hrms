<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFilenameTableChangeTypeOfColumns extends Migration
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
            if(\Schema::hasColumn('filenames', 'original_name'))
            {
                $table->dropColumn('original_name');
            }

            if(!Schema::hasColumn('filenames', 'original_name'))
            {
                $table->string('original_name')->after('id');
            }

            if(\Schema::hasColumn('filenames', 'input_name'))
            {
                $table->dropColumn('input_name');
            }

            if(!Schema::hasColumn('filenames', 'input_name'))
            {
                $table->string('input_name')->after('original_name');
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
