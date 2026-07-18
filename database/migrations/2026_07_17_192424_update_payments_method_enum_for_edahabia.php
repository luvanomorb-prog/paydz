<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE payments
            DROP CONSTRAINT IF EXISTS payments_method_check
        ");

        DB::statement("
            ALTER TABLE payments
            ADD CONSTRAINT payments_method_check
            CHECK (
                method IN (
                    'cib',
                    'edahabia',
                    'baridimob',
                    'qr'
                )
            )
        ");
    }


    public function down(): void
    {
        DB::statement("
            ALTER TABLE payments
            DROP CONSTRAINT IF EXISTS payments_method_check
        ");

        DB::statement("
            ALTER TABLE payments
            ADD CONSTRAINT payments_method_check
            CHECK (
                method IN (
                    'cib',
                    'baridimob',
                    'qr'
                )
            )
        ");
    }
};
