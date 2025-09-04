<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('decks', function (Blueprint $table) {
            $table->integer('display_order')->default(0)->after('description');
            $table->index(['user_id', 'display_order']);
        });

        // Set initial display_order values for existing decks based on creation date
        DB::statement('
            SET @row_number = 0;
            UPDATE decks 
            SET display_order = (@row_number:=@row_number+1) - 1
            ORDER BY user_id, created_at ASC;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('decks', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'display_order']);
            $table->dropColumn('display_order');
        });
    }
};
