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
        Schema::table('properties', function (Blueprint $table) {
            $table->string('address_2')->after('address')->nullable();
        });
        Schema::table('branches', function (Blueprint $table) {
            $table->string('address_2')->after('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('address_2');
        });
        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn('address_2');
        });
    }
};
