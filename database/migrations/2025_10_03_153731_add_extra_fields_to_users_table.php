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
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->after('id');
            $table->string('phone_number')->nullable()->after('email');
            $table->string('profile_photo')->nullable()->after('phone_number');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('profile_photo');
            $table->date('date_of_birth')->nullable()->after('gender');
            $table->text('bio')->nullable()->after('profile_photo');
            $table->string('role')->default('customer')->after('bio');
            $table->boolean('is_active')->default(true)->after('password');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'uuid',
                'phone_number',
                'profile_photo',
                'gender',
                'date_of_birth',
                'bio',
                'role',
                'is_active',
                'last_login_at',
            ]);
        });
    }
};
