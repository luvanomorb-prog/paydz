<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{

    public function up(): void
    {

        /*
        |--------------------------------------------------------------------------
        | Remove old enum constraint
        |--------------------------------------------------------------------------
        */

        DB::statement("
            ALTER TABLE payments
            DROP CONSTRAINT IF EXISTS payments_method_check
        ");



        /*
        |--------------------------------------------------------------------------
        | Convert payment method to flexible string
        |--------------------------------------------------------------------------
        */

        DB::statement("
            ALTER TABLE payments
            ALTER COLUMN method TYPE VARCHAR(50)
            USING method::text
        ");



        /*
        |--------------------------------------------------------------------------
        | Create payment methods registry
        |--------------------------------------------------------------------------
        */

        Schema::create('payment_methods', function (Blueprint $table) {

            $table->id();

            $table->string('code')
                ->unique();

            $table->string('name');

            $table->string('provider')
                ->nullable();

            $table->boolean('active')
                ->default(true);

            $table->json('settings')
                ->nullable();

            $table->timestamps();

        });



        /*
        |--------------------------------------------------------------------------
        | Default payment methods
        |--------------------------------------------------------------------------
        */

        DB::table('payment_methods')->insert([

            [
                'code' => 'cib',
                'name' => 'CIB Bank Card',
                'provider' => 'SATIM',
                'active' => true,
            ],

            [
                'code' => 'edahabia',
                'name' => 'Edahabia Card',
                'provider' => 'SATIM',
                'active' => true,
            ],

            [
                'code' => 'baridimob',
                'name' => 'BaridiMob',
                'provider' => 'BARIDIMOB',
                'active' => true,
            ],

        ]);

    }



    public function down(): void
    {

        Schema::dropIfExists('payment_methods');

    }

};
