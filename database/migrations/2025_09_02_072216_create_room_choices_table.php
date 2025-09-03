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
        Schema::create('room_choices', function (Blueprint $table) {
            $table->id('rchoice_id');
            $table->foreignId('booking_id')->constrained('bookings', 'booking_id');
            $table->foreignId('accom_id')->constrained('accommodations', 'accom_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_choices');
    }
};
