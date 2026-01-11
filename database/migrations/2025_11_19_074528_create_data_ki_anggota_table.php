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
        Schema::create('data_ki_anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_ki')->constrained('data_ki')->cascadeOnDelete();
            $table->foreignId('id_mahasiswa')->nullable()->constrained('data_mahasiswa');
            $table->foreignId('id_dosen')->nullable()->constrained('data_dosen');
            $table->string('anggota')->nullable();
            $table->string('status_anggota')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_ki_anggota');
    }
};
