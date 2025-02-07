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
        Schema::create('conversation_request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filachat_conversation_id')->constrained('filachat_conversations')->cascadeOnDelete();
            $table->foreignId('request_id')->constrained('requests')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['filachat_conversation_id', 'request_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversation_request');
    }
};
