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
        Schema::create('laporan_bertugas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kod_laporan', 100)->unique();
            $table->text('ulasan')->nullable();
            $table->timestamp('masa_tandatangan')->nullable();
            $table->json('senarai_semak')->nullable(); // Disimpan dalam format JSON
            $table->string('status_pengesahan', 50)->default('dalam_proses');
            $table->string('ulasan_ppkj')->nullable();
            $table->string('status_tindakan_pka', 50)->nullable();

            // Foreign key
            $table->uuid('jadual_id');
            $table->foreign('jadual_id')->references('id')->on('jaduals')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
