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
            // Rename status to is_available to match model
            $table->renameColumn('status', 'is_available');

            // Remove columns that are not in the model's $fillable
            $table->dropColumn(['is_furnished', 'aturan_khusus']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kamar', function (Blueprint $table) {
            // Revert rename
            $table->renameColumn('is_available', 'status');

            // Re-add dropped columns
            $table->boolean('is_furnished')->default(false);
            $table->text('aturan_khusus')->nullable();
        });
    }
};
