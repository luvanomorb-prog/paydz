<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_links', function (Blueprint $table) {

            $table->unsignedInteger('views_count')
                ->default(0)
                ->after('payments_count');

            $table->decimal('revenue', 14, 2)
                ->default(0)
                ->after('views_count');

            $table->index('uuid');
            $table->index('active');
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('payment_links', function (Blueprint $table) {

            $table->dropIndex(['uuid']);
            $table->dropIndex(['active']);
            $table->dropIndex(['expires_at']);

            $table->dropColumn([
                'views_count',
                'revenue',
            ]);
        });
    }
};
