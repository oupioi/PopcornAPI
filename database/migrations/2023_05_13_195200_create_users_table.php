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
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->string('email', 255)->unique();
            $table->string('role')->default('user');
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('description',255)->nullable();
            $table->string('pays')->nullable();
            $table->string('statut')->nullable();
            $table->timestamps();
            $table->string('api_token', 80)->unique()->nullable()->default(null);
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
