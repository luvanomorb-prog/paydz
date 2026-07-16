<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('api_keys', function (Blueprint $table) {
            $table->string('secret_key_hash')->nullable()->after('public_key');
            $table->dropColumn('secret_key');
        });
    }

    public function down(): void
    {
        Schema::table('api_keys', function (Blueprint $table) {
            $table->string('secret_key')->nullable()->after('public_key');
            $table->dropColumn('secret_key_hash');
        });
    }
};
