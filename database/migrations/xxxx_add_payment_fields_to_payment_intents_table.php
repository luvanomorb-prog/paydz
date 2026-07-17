<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_intents', function (Blueprint $table) {

            if (!Schema::hasColumn('payment_intents','intent_id')) {
                $table->string('intent_id')->unique()->after('id');
            }

            if (!Schema::hasColumn('payment_intents','payment_method')) {
                $table->string('payment_method')
                    ->default('mock')
                    ->after('status');
            }

            if (!Schema::hasColumn('payment_intents','description')) {
                $table->text('description')
                    ->nullable()
                    ->after('payment_method');
            }

        });
    }


    public function down(): void
    {
        Schema::table('payment_intents', function (Blueprint $table) {

            $table->dropColumn([
                'intent_id',
                'payment_method',
                'description'
            ]);

        });
    }
};
