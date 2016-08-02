<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFilenameTableAddColumns extends Migration
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
            if(\Schema::hasColumn('filenames', 'name'))
            {
                $table->dropColumn('name');
            }

            if(!Schema::hasColumn('filenames', 'original_name'))
            {
                $table->date('original_name')->after('id');
            }

            if(!Schema::hasColumn('filenames', 'input_name')) {
                $table->date('input_name')->after('original_name');
            }

            if(!Schema::hasColumn('filenames', 'date'))
            {
                $table->date('date')->after('input_name');
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
