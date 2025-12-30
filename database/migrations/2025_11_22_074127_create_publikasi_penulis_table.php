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
        Schema::create('data_publikasi_penulis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_publikasi')->constrained('data_publikasi')->cascadeOnDelete();
            $table->foreignId('id_mahasiswa')->nullable()->constrained('data_mahasiswa');
            $table->foreignId('id_dosen')->nullable()->constrained('data_dosen');
            $table->string('nama_penulis')->nullable();
            $table->string('prodi')->nullable();
            $table->string('status')->nullable();
            $table->string('afiliasi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_publikasi_penulis');
    }
};
