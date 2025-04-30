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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->foreign('request_id')->references('id')->on('alert_requests');
            $table->unsignedBigInteger('response_id');
            $table->foreign('response_id')->references('id')->on('response');        
            $table->integer('response_time')->nullable();
            $table->time('site_arrival')->nullable();
            $table->string('patient_contact')->nullable();
            $table->time('site_departure')->nullable();
            $table->time('hospital_arrival')->nullable();
            $table->time('station_arrival')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
