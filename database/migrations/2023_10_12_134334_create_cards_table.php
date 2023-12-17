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
        Schema::create('cards', function (Blueprint $table) {
            $table->id()->comment('Primary key of the card');
            $table->foreignId('deck_id')->constrained()->cascadeOnDelete()->comment('Foreign key referencing the deck');
            $table->text('front')->comment('Front side of the card');
            $table->text('back')->comment('Back side of the card');
            $table->text('pronunciation')->nullable()->comment('Pronunciation of the card content');
            $table->integer('review_level')->default(0)->comment('Review level of the card');
            $table->date('last_reviewed_date')->nullable()->default(now())->comment('Date when the card was last reviewed');
            $table->date('next_review_date')->nullable()->default(now())->comment('Date for the next review of the card');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Time when the record was created');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Time when the record was last updated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
