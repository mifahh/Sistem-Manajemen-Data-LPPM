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
        Schema::create('penelitian_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penelitian')->constrained('penelitian_main')->cascadeOnDelete();

            // Mahasiswa information
            $table->string('nama_mhs')->nullable();
            $table->string('prodi_mhs')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penelitian_mahasiswa');
    }
};
