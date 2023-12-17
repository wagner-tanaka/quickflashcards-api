<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('decks', function (Blueprint $table) {
            $table->id()->comment('Primary key of the deck');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->comment('Foreign key referencing the user');
            $table->string('name', 100)->comment('Name of the deck');
            $table->text('description')->nullable()->comment('Description of the deck');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('decks');
    }
};
