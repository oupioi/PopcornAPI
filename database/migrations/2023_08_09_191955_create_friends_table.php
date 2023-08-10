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
        Schema::create('friends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('friend_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('accepted')->default(false);
            $table->boolean('blocked')->default(false);
            $table->boolean('favorite')->default(false);
            $table->boolean('following')->default(false);
            $table->boolean('follower')->default(false);
            $table->boolean('mutual')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friends');
    }
};
