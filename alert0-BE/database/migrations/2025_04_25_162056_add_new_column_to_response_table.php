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
        Schema::table('response', function (Blueprint $table) {
            $table->string('responders_response')->after('request_status')->nullable();
            $table->string('drivers_response')->after('request_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('response', function (Blueprint $table) {
            //
        });
    }
};
