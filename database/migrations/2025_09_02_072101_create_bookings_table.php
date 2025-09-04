<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->date('booking_date');
            $table->string('payment_status', 50);
            $table->string('payment_transaction_id', 100)->nullable();
            $table->string('special_request', 100)->nullable();
            $table->string('address', 50);
            $table->string('phone', 50);
            $table->string('nationality', 50);
            $table->string('package_status', 50);
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->foreignId('schedule_id')->constrained('schedules', 'schedule_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
