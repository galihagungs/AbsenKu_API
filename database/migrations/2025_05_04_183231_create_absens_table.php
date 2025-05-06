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
        Schema::create('absens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->dateTime('check_in')->nullable();
            $table->string('check_in_location')->nullable();
            $table->string('check_in_address')->nullable();
            $table->dateTime('check_out')->nullable();
            $table->string('check_out_location')->nullable();
            $table->string('check_out_address')->nullable();
            $table->string('status')->nullable();
            $table->string('alasan_izin')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absens');
    }
};
