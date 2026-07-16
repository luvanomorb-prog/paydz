<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('merchant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('payment_id')->unique();

            $table->decimal('amount',12,2);

            $table->string('currency')->default('DZD');

            $table->string('customer_email');

            $table->string('customer_name')->nullable();

            $table->string('description')->nullable();

            $table->enum('status',[
                'pending',
                'paid',
                'failed',
                'cancelled',
                'expired'
            ])->default('pending');

            $table->string('provider')->nullable();

            $table->string('provider_reference')->nullable();

            $table->json('metadata')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
