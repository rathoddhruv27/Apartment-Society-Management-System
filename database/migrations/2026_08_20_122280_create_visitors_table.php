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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('apartment_id')->nullable()->constrained('apartments')->nullOnDelete();
            $table->string('name');
            $table->string('phone');
            $table->string('vehicle_number')->nullable();
            $table->string('purpose')->nullable();
            $table->timestamp('entry_time')->nullable();
            $table->timestamp('exit_time')->nullable();
            $table->enum('status', ['expected', 'checked_in', 'checked_out', 'denied'])->default('expected');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
