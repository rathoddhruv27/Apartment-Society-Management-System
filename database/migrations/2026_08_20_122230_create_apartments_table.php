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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained('buildings')->cascadeOnDelete();
            $table->string('apartment_number');
            $table->integer('floor_number')->nullable();
            $table->string('type')->default('2BHK'); // 1BHK, 2BHK, 3BHK, Villa, Studio, etc.
            $table->enum('status', ['occupied', 'vacant', 'rented'])->default('vacant');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
