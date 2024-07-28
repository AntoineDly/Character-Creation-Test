<?php

declare(strict_types=1);

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
        Schema::create('category_game', function (Blueprint $table) {
            $table->foreignUuid('game_id')->references('id')->on('games');
            $table->foreignUuid('category_id')->references('id')->on('categories');
            $table->primary(['game_id', 'category_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_games');
    }
};
