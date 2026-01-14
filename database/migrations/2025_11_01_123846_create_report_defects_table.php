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
        Schema::create('report_defects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_inspection_area_id')->constrained('report_inspection_areas')->cascadeOnDelete();
            $table->foreignId('inspection_area_item_id')->nullable()->constrained('inspection_area_items')->cascadeOnDelete();
            $table->enum('defect_type', ['cosmetic', 'structural', 'safety', 'none'])->default('none');
            $table->enum('remediation', ['cleaning', 'maintenance', 'none'])->default('none')->comment('Action required to address the defect');
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_defects');
    }
};
