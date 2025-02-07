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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('name');
            $table->json('images')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('quantity', 10, 2);
            $table->integer('chat_nb')->default(0);
            $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
