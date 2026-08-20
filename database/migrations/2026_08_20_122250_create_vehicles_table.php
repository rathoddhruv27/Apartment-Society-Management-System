<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('apartment_id')->nullable()->constrained('apartments')->nullOnDelete();
            $table->string('vehicle_number');
            $table->enum('vehicle_type', ['car', 'two_wheeler', 'bicycle', 'other'])->default('car');
            $table->string('model')->nullable();
            $table->string('parking_slot')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
