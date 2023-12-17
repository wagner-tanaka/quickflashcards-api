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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100)->comment('First name of the user');
            $table->string('last_name', 100)->comment('Last name of the user');
            $table->string('email', 150)->unique()->comment('Email address of the user');
            $table->timestamp('email_verified_at')->nullable()->comment('Timestamp when the email was verified');
            $table->string('password')->comment('Password for the user account');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
