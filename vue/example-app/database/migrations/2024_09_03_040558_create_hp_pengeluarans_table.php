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
        Schema::create('hp_pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nominal');
            $table->date('tanggal');
            $table->string('deskripsi');
            $table->string('pihak_kedua');
            $table->string('metode_pembayaran');
            $table->string('status');
            $table->unsignedBigInteger('hp_pemasukan_id');
            $table->foreign('hp_pemasukan_id')->references('id')->on('hp_pemasukans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hp_pengeluarans');
    }
};
