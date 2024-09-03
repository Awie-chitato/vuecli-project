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
        Schema::create('event_pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("nominal");
            $table->date("tanggal");
            $table->string("deskripsi");
            $table->string("metode_pembayaran");
            $table->string("status");
            $table->unsignedBigInteger("event_id");
            $table->foreign("event_id")->references("id")->on("event_anyar")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_pengeluarans');
    }
};
