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
        Schema::create('game_rounds', function (Blueprint $table) {
            $table->id();
            $table->integer('result_number')->nullable();
            $table->enum('result_color', ['red', 'green', 'violet'])->nullable();
            $table->enum('result_size', ['big', 'small'])->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->boolean('is_manual')->default(false);
            $table->integer('manual_number')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_rounds');
    }
};
