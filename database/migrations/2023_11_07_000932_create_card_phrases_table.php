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
        Schema::create('card_phrases', function (Blueprint $table) {
            $table->id()->comment('Primary key of the card phrase');
            $table->foreignId('card_id')->constrained()->cascadeOnDelete()->comment('Foreign key referencing the card');
            $table->text('phrase')->comment('Phrase associated with the card');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Time when the record was created');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Time when the record was last updated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_phrases');
    }
};
