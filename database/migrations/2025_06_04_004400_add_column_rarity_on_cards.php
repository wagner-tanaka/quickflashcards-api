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

        if (Schema::hasColumn('cards', 'rarity')) {
            return;
        }

        Schema::table('cards', function (Blueprint $table) {
            $table->string('rarity')->nullable()->after('pronunciation');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('cards')) {
            return;
        }

        if (!Schema::hasColumn('cards', 'rarity')) {
            return;
        }

        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn('rarity');
        });
    }
};
