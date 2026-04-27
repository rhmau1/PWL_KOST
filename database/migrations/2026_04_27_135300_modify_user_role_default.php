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
        Schema::table('users', function (Blueprint $table) {
            // Remove the default value 'penghuni' from the role column
            // so that the Model logic (User::booted) can handle it dynamically.
            $table->enum('role', ['admin', 'penghuni'])->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restore the default value if needed
            $table->enum('role', ['admin', 'penghuni'])->default('penghuni')->change();
        });
    }
};
