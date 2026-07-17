<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_links', function (Blueprint $table) {

            if (!Schema::hasColumn('payment_links', 'public_id')) {

                $table->string('public_id',40)
                    ->unique()
                    ->after('merchant_id');

            }

        });
    }

    public function down(): void
    {
        Schema::table('payment_links', function (Blueprint $table) {

            if (Schema::hasColumn('payment_links','public_id')) {

                $table->dropUnique(['public_id']);

                $table->dropColumn('public_id');

            }

        });
    }
};
