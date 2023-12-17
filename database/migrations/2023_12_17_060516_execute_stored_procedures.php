<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ExecuteStoredProcedures extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $path = database_path('routines/insert_card_phrase_procedure.sql');
        $sql = File::get($path);
        DB::unprepared($sql);

        $path = database_path('routines/insert_card_procedure.sql');
        $sql = File::get($path);
        DB::unprepared($sql);
    }
}
