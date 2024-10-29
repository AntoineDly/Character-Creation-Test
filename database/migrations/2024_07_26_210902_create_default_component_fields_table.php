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
        Schema::create('default_component_fields', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('value');
            $table->foreignUuid('component_id')->references('id')->on('components');
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
        Schema::dropIfExists('default_component_fields');
    }
};
