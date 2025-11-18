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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
    $table->foreignId('subscription_id')->nullable()->constrained()->nullOnDelete();
    $table->foreignId('plan_id')->nullable()->constrained('subscription_plans')->nullOnDelete();

    $table->decimal('amount', 10, 2);
    $table->string('currency', 10)->default('USD');

    $table->string('gateway')->nullable();               
    $table->string('gateway_transaction_id')->nullable();

    $table->enum('type', [
        'subscription_payment',
        'one_time_purchase',
        'wallet_topup',
        'refund',
        'adjustment'
    ]);
    $table->enum('status', [
        'pending','paid','failed','refunded','canceled'
    ])->default('pending');
    $table->dateTime('paid_at')->nullable();
    $table->dateTime('refunded_at')->nullable();
    $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
