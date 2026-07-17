<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_links', function (Blueprint $table) {

            $table->id();

            $table->foreignId('merchant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('uuid')->unique();

            $table->string('title');

            $table->text('description')->nullable();

            $table->decimal('amount', 12, 2);

            $table->string('currency', 3)->default('DZD');

            $table->boolean('active')->default(true);

            $table->integer('max_payments')->nullable();

            $table->integer('payments_count')->default(0);

            $table->timestamp('expires_at')->nullable();

            $table->boolean('collect_name')->default(true);

            $table->boolean('collect_email')->default(true);

            $table->boolean('collect_phone')->default(false);

            $table->string('success_url')->nullable();

            $table->string('cancel_url')->nullable();

            $table->json('metadata')->nullable();

            $table->timestamps();

            $table->index('merchant_id');
            $table->index('uuid');
            $table->index('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_links');
    }
};
