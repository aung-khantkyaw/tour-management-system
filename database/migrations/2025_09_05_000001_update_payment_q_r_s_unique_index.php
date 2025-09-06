<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payment_q_r_s', function (Blueprint $table) {
            try {
                $table->dropUnique('payment_q_r_s_qr_type_unique');
            } catch (\Throwable $e) {
            }
        });
        Schema::table('payment_q_r_s', function (Blueprint $table) {
            $table->unique(['qr_type', 'amount'], 'payment_q_r_s_type_amount_unique');
        });
    }

    public function down(): void
    {
        Schema::table('payment_q_r_s', function (Blueprint $table) {
            try {
                $table->dropUnique('payment_q_r_s_type_amount_unique');
            } catch (\Throwable $e) {
            }
        });
        Schema::table('payment_q_r_s', function (Blueprint $table) {
            try {
                $table->unique(['qr_type']);
            } catch (\Throwable $e) {
            }
        });
    }
};
