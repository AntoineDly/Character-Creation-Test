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
        Schema::create('categories_parameters', function (Blueprint $table) {
            $table->foreignUuid('parameter_id')->references('id')->on('parameters');
            $table->foreignUuid('categorie_id')->references('id')->on('categories');
            $table->primary(['parameter_id', 'categorie_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_parameters');
    }
};
