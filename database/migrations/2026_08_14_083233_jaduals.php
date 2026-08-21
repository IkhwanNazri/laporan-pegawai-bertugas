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
        Schema::create('jaduals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('tarikh');
            $table->string('aras', 50);
            $table->string('no_telefon')->nullable();
            $table->string('jenis', 50)->default('harian');

            // Foreign keys
            $table->uuid('bahagian_id');
            $table->foreign('bahagian_id')->references('id')->on('bahagians')->onDelete('cascade');

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->unsignedBigInteger('pegawai_ganti_id')->nullable();
            $table->foreign('pegawai_ganti_id')->references('id')->on('users')->onDelete('set null');

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
