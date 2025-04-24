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
        Schema::create('response', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->foreign('request_id')->references('id')->on('alert_requests');
            $table->unsignedBigInteger('responders_id');
            $table->foreign('responders_id')->references('id')->on('users');
            $table->unsignedBigInteger('drivers_id');
            $table->foreign('drivers_id')->references('id')->on('users');
            $table->decimal('current_latitude', 10, 7)->nullable();
            $table->decimal('current_longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('response');
    }
};
