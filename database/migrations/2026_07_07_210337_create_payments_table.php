k<?php

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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('merchant_id')->constrained('merchants')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('payment_link_id')->nullable()->constrained('payment_links')->nullOnDelete();
            $table->string('payment_intent_id')->nullable()->index();
            $table->string('transaction_id')->nullable()->index();
            $table->bigInteger('amount'); // Stored in minor units (e.g. cents/centimes) to avoid float mismatch
            $table->string('currency', 3)->default('DZD');
            $table->string('status', 30)->default('pending')->index();
            $table->string('gateway', 50)->index();
            $table->string('payment_method', 50)->nullable();
            $table->string('description', 500)->nullable();
            $table->jsonb('metadata')->nullable();
            $table->jsonb('gateway_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();

            $table->index(['merchant_id', 'status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
