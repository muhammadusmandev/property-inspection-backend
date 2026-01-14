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
        Schema::create('inspection_area_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained('inspection_areas')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('inspection_area_items')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('inspection_area_item');
    }
};
