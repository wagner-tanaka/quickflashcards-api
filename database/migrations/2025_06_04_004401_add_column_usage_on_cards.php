<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('cards')) {
            return;
        }

        if (Schema::hasColumn('cards', 'usage')) {
            return;
        }

        Schema::table('cards', function (Blueprint $table) {
            $table->string('usage')->nullable()->after('rarity');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('cards')) {
            return;
        }

        if (!Schema::hasColumn('cards', 'usage')) {
            return;
        }

        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn('usage');
        });
    }
};
