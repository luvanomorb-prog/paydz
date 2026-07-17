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
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Merchant
            |--------------------------------------------------------------------------
            */
            $table->foreignId('merchant_id')
                ->constrained()
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Payment Link
            | بدون foreign key حاليا لأن payment_links ينشأ لاحقا
            |--------------------------------------------------------------------------
            */
            $table->unsignedBigInteger('payment_link_id')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Customer
            |--------------------------------------------------------------------------
            */
            $table->string('customer_name')
                ->nullable();

            $table->string('customer_email')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Amount
            |--------------------------------------------------------------------------
            */
            $table->decimal('amount', 12, 2);

            $table->string('currency')
                ->default('DZD');


            /*
            |--------------------------------------------------------------------------
            | Payment Method
            |--------------------------------------------------------------------------
            */
            $table->enum('method', [

                'cib',
                'baridimob',
                'qr'

            ])->default('baridimob');


            /*
            |--------------------------------------------------------------------------
            | Payment Status
            |--------------------------------------------------------------------------
            */
            $table->enum('status', [

                'pending',
                'paid',
                'failed',
                'refunded'

            ])->default('pending');


            /*
            |--------------------------------------------------------------------------
            | Internal Transaction ID
            |--------------------------------------------------------------------------
            */
            $table->string('transaction_id')
                ->unique();


            /*
            |--------------------------------------------------------------------------
            | Gateway Data
            |--------------------------------------------------------------------------
            */
            $table->json('metadata')
                ->nullable();


            $table->timestamps();

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
