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
        Schema::create('data_publikasi', function (Blueprint $table) {
            $table->id();
            $table->text('judul_publikasi');
            $table->string('nama_jurnal')->nullable();
            $table->string('akreditasi_index_jurnal')->nullable();
            $table->string('lembaga_pengindeks')->nullable();
            $table->integer('tahun_published')->nullable();
            $table->foreignId('id_dosen')->nullable()->constrained('data_dosen');
            $table->string('nama_penulis_koresponding')->nullable();
            $table->string('prodi')->nullable();
            $table->string('status')->nullable();
            $table->string('afiliasi')->nullable();
            $table->text('doi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_publikasi');
    }
};
