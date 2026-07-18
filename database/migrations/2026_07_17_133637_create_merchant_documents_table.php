<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{


    public function up(): void
    {

        Schema::create('merchant_documents', function (Blueprint $table) {


            $table->id();



            $table->foreignId('merchant_id')
                ->constrained()
                ->cascadeOnDelete();



            $table->enum('type',[

                'identity_card',
                'passport',
                'business_registration',
                'tax_document',
                'bank_document',
                'address_proof'

            ]);



            $table->string('file_path');



            $table->enum('status',[

                'pending',
                'approved',
                'rejected'

            ])
            ->default('pending');



            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();



            $table->timestamp('reviewed_at')
                ->nullable();



            $table->text('rejection_reason')
                ->nullable();



            $table->timestamps();


        });


    }





    public function down(): void
    {

        Schema::dropIfExists('merchant_documents');

    }


};
