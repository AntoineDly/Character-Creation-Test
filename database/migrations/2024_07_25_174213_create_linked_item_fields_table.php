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
        Schema::create('linked_item_fields', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('value');
            $table->foreignUuid('linked_item_id')->references('id')->on('linked_items');
            $table->foreignUuid('parameter_id')->references('id')->on('parameters');
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
