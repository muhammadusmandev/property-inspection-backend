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
        Schema::create('user_billing_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('stripe_payment_method')->nullable();
            $table->string('name');
            $table->string('email');
            $table->text('address')->nullable();
            $table->text('address_2')->nullable(); 
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country_code', 2)->nullable();
            $table->string('postal_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_billing_details');
    }
};
