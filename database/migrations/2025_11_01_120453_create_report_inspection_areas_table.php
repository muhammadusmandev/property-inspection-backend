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
        Schema::create('report_inspection_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->cascadeOnDelete();
            $table->string('name',100);
            $table->enum('condition',['excellent', 'good', 'fair', 'poor', 'Unacceptable'])->default('good');
            $table->enum('cleanliness',['excellent', 'good', 'fair', 'poor', 'Unacceptable'])->default('good');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_inspection_areas');
    }
};
