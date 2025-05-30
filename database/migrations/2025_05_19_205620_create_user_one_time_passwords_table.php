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
        Schema::create('user_one_time_passwords', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('otp')->unique();
            $table->dateTime('expires_at');
            $table->dateTime('verified_at')->nullable();
            $table->enum('type', ['REGISTRATION', 'LOGIN', 'PASSWORD_RESET', 'VERIFY'])->default('LOGIN');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_one_time_passwords');
    }
};
