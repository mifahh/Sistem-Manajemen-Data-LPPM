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
        Schema::create('abdimas_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_abdimas')->constrained('abdimas_main')->cascadeOnDelete();
            $table->foreignId('id_mahasiswa')->nullable()->constrained('data_mahasiswa');

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
        Schema::dropIfExists('abdimas_mahasiswa');
    }
};
