<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('business_name');
            $table->string('business_email')->unique();
            $table->string('business_phone')->nullable();

            $table->string('country')->default('Algeria');

            $table->enum('status', [
                'pending',
                'verified',
                'rejected',
                'suspended',
            ])->default('pending');

            $table->boolean('kyc_verified')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
