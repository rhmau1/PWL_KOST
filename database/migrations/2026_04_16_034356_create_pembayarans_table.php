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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();

            // relasi utama
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('kos_id')->constrained('kos', 'id')->cascadeOnDelete();
            $table->foreignId('kamar_id')->constrained('kamar', 'nomor')->cascadeOnDelete();

            // jenis pembayaran
            $table->enum('tipe', ['booking', 'sewa']);

            // nominal
            $table->integer('jumlah');

            // bukti pembayaran
            $table->string('bukti_pembayaran');

            // status verifikasi
            $table->enum('status', ['pending', 'verified', 'rejected'])
                ->default('pending');

            // tanggal
            $table->date('tanggal_bayar')->nullable();

            // catatan admin (opsional)
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
