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
        // Tambah kolom file proposal di tabel recruitments
        Schema::table('recruitments', function (Blueprint $table) {
            $table->string('proposal_file')->nullable(); // Path file PDF
        });

        // Tambah kolom 'is_pinned' di tabel applications (untuk portfolio profile)
        Schema::table('applications', function (Blueprint $table) {
            $table->boolean('is_pinned')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recruitments_and_applications', function (Blueprint $table) {
            //
        });
    }
};
