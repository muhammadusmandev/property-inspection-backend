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
        Schema::create('inspection_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('realtor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('name', 150);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('inspection_areas');
        Schema::enableForeignKeyConstraints();
    }
};
