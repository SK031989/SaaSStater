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
        // 1. Payment Gateways Table
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique(); // stripe, paypal, razorpay, bank_transfer
            $table->string('mode')->default('sandbox'); // sandbox, live
            $table->json('credentials')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->text('instructions')->nullable();
            $table->timestamps();
        });

        // 2. Payment Transactions Table
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('gateway_id')->nullable()->constrained('payment_gateways')->onDelete('set null');
            $table->string('transaction_id')->unique();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('USD');
            $table->string('status')->default('completed'); // completed, pending, failed, refunded
            $table->string('payment_method')->nullable(); // card, paypal_account, bank_transfer
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'status']);
            $table->index('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
        Schema::dropIfExists('payment_gateways');
    }
};
