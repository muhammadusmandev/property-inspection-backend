<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('realtor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->after('id');
            $table->index('realtor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['realtor_id']);
            $table->dropIndex(['realtor_id']);
            $table->dropColumn('realtor_id');
        });
    }
};
