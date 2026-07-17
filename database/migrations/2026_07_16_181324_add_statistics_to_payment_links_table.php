<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_links', function (Blueprint $table) {

            if (! Schema::hasColumn('payment_links', 'views_count')) {
                $table->unsignedInteger('views_count')
                    ->default(0)
                    ->after('payments_count');
            }

            if (! Schema::hasColumn('payment_links', 'revenue')) {
                $table->decimal('revenue', 14, 2)
                    ->default(0)
                    ->after('views_count');
            }

        });
    }

    public function down(): void
    {
        Schema::table('payment_links', function (Blueprint $table) {

            if (Schema::hasColumn('payment_links', 'views_count')) {
                $table->dropColumn('views_count');
            }

            if (Schema::hasColumn('payment_links', 'revenue')) {
                $table->dropColumn('revenue');
            }

        });
    }
};
