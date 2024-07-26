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
        Schema::create('items_characters', function (Blueprint $table) {
            $table->foreignUuid('item_id')->references('id')->on('items');
            $table->foreignUuid('character_id')->references('id')->on('characters');
            $table->primary(['item_id', 'character_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_characters');
    }
};
