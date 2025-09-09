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
        Schema::dropIfExists('payment_q_r_s');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate the table structure if rolling back
        Schema::create('payment_q_r_s', function (Blueprint $table) {
            $table->id('qr_id');
            $table->string('qr_image_path', 255);
            $table->string('qr_type', 30)->index();
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->timestamps();
            $table->unique(['qr_type']);
        });
    }
};
