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
        Schema::create('payment_q_r_s', function (Blueprint $table) {
            $table->id('qr_id');
            // Path (relative) to stored QR image (e.g. storage/app/public/qrcodes/xyz.png)
            $table->string('qr_image_path', 255);
            // Payment method / provider key: e.g. 'kpay', 'kbzpay', 'ayarpay', 'uabpay'
            $table->string('qr_type', 30)->index();
            // Optional description / label for display
            $table->string('description', 120)->nullable();
            // Default amount encoded in the QR (0 if dynamic / not encoded)
            $table->unsignedInteger('amount')->default(0);
            $table->timestamps();

            // If you intend only one active QR per type, you can enforce uniqueness:
            $table->unique(['qr_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_q_r_s');
    }
};
