<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::table('checkout_sessions', function (Blueprint $table) {


            $table->foreignId('merchant_id')
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();


            $table->unsignedBigInteger('payment_id')
                ->nullable()
                ->after('merchant_id');


            $table->string('session_id')
                ->unique()
                ->after('payment_id');


            $table->string('customer_name')
                ->nullable()
                ->after('session_id');


            $table->string('customer_email')
                ->nullable()
                ->after('customer_name');


            $table->decimal('amount',12,2)
                ->after('customer_email');


            $table->string('currency')
                ->default('DZD')
                ->after('amount');


            $table->enum('status',[

                'open',
                'completed',
                'expired',
                'cancelled'

            ])
            ->default('open')
            ->after('currency');



            $table->text('success_url')
                ->nullable()
                ->after('status');


            $table->text('cancel_url')
                ->nullable()
                ->after('success_url');


            $table->json('metadata')
                ->nullable()
                ->after('cancel_url');


        });

    }



    public function down(): void
    {

        Schema::table('checkout_sessions', function (Blueprint $table) {


            $table->dropForeign([
                'merchant_id'
            ]);


            $table->dropColumn([

                'merchant_id',
                'payment_id',
                'session_id',
                'customer_name',
                'customer_email',
                'amount',
                'currency',
                'status',
                'success_url',
                'cancel_url',
                'metadata'

            ]);

        });

    }

};
