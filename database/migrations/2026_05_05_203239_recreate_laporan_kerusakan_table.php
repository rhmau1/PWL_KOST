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
        Schema::dropIfExists('laporan_kerusakans');

        Schema::create('laporan_kerusakan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kamar');
            $table->unsignedBigInteger('id_penghuni');
            $table->string('jenis_kerusakan');
            $table->text('detail_kerusakan');
            $table->string('foto_bukti')->nullable();
            $table->enum('status', ['pending', 'diproses', 'selesai'])->default('pending');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_kamar')->references('id')->on('kamar')->onDelete('cascade');
            $table->foreign('id_penghuni')->references('id')->on('penghuni')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kerusakan');

        Schema::create('laporan_kerusakans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
};
