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
        Schema::table('kamar', function (Blueprint $table) {
            $table->json('images')->nullable();
            $table->string('tipe_penghuni')->default('Campur');
            $table->integer('kapasitas')->default(1);
            $table->boolean('is_furnished')->default(false);
            $table->text('aturan_khusus')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kamar', function (Blueprint $table) {
            $table->dropColumn(['images', 'tipe_penghuni', 'kapasitas', 'is_furnished', 'aturan_khusus']);
        });
    }
};
