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
        Schema::create('tourist_packages', function (Blueprint $table) {
            $table->id('package_id');
            $table->string('package_name', 50);
            $table->string('duration_days', 50);
            $table->integer('no_of_people');
            $table->string('vehicle_type', 50);
            $table->integer('singlepackage_fee');
            $table->integer('fullpackage_fee');
            $table->foreignId('destination_id')->constrained('destinations', 'destination_id')->onDelete('cascade');
            $table->foreignId('guide_id')->constrained('guides', 'guide_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_packages');
    }
};
