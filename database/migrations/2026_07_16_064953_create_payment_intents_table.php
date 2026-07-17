<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_intents', function (Blueprint $table) {

            $table->id();

            $table->uuid('intent_id')->unique();

            $table->foreignId('merchant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('payment_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->decimal('amount', 12, 2);

            $table->string('currency')->default('DZD');

            $table->enum('status', [
                'requires_payment_method',
                'requires_confirmation',
                'processing',
                'succeeded',
                'failed',
                'cancelled'
            ])->default('requires_payment_method');

            $table->string('client_secret')->unique();

            $table->json('metadata')->nullable();

            $table->timestamp('confirmed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_intents');
    }
};
