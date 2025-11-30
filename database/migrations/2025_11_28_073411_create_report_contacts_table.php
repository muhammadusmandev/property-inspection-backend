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
        Schema::create('report_contacts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('report_id')->constrained()->onDelete('cascade');
            $table->enum('contact_type', [
                'landlord',
                'tenant',
                'co_tenant',
                'owner',
                'occupant',
                'property_manager',
                'letting_agent',
                'estate_agent',
                'contractor',
                'inspector',
                'witness',
                'legal_representative',
                'insurance_assessor',
                'company_representative',
                'emergency_contact',
                'other',
            ]);
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('can_sign')->default(false);
            $table->boolean('can_email')->default(false);
            $table->boolean('can_sms')->default(false);
            $table->string('signature_token', 64)->nullable()->unique();
            $table->string('signature_path')->nullable();
            $table->text('signature_data')->nullable()->comment('Raw base64 canvas data');
            $table->timestamp('signed_at')->nullable();
            $table->string('signed_by_ip')->nullable();
            $table->string('signed_hash')->nullable()->comment('Hash of signature content for tamper checking');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_contacts');
    }
};
