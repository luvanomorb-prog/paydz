<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_intents', function (Blueprint $table) {
            if (! Schema::hasColumn('payment_intents', 'gateway')) {
                $table->string('gateway')->default('mock')->after('status');
            }
            if (! Schema::hasColumn('payment_intents', 'gateway_reference')) {
                $table->string('gateway_reference')->nullable()->after('gateway');
            }
            if (! Schema::hasColumn('payment_intents', 'redirect_url')) {
                $table->string('redirect_url')->nullable()->after('gateway_reference');
            }
            if (! Schema::hasColumn('payment_intents', 'last_error')) {
                $table->text('last_error')->nullable()->after('redirect_url');
            }
        });

        Schema::table('transactions', function (Blueprint $table) {
            if (! Schema::hasColumn('transactions', 'payment_intent_id')) {
                $table->foreignId('payment_intent_id')->nullable()->constrained()->nullOnDelete();
            }
            if (! Schema::hasColumn('transactions', 'gateway')) {
                $table->string('gateway')->nullable();
            }
            if (! Schema::hasColumn('transactions', 'gateway_reference')) {
                $table->string('gateway_reference')->nullable();
            }
            if (! Schema::hasColumn('transactions', 'raw_response')) {
                $table->text('raw_response')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('payment_intents', function (Blueprint $table) {
            $table->dropColumn(['gateway', 'gateway_reference', 'redirect_url', 'last_error']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['payment_intent_id', 'gateway', 'gateway_reference', 'raw_response']);
        });
    }
};
