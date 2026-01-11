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
        Schema::create('penelitian_main', function (Blueprint $table) {
            $table->id();

            // Core information
            $table->text('link_sk')->nullable();
            $table->string('no_sk')->nullable();
            $table->text('link_kontrak')->nullable();
            $table->string('no_kontrak')->nullable();
            $table->text('judul_penelitian')->unique();
            $table->string('nama_skema')->nullable();
            $table->integer('tahun_usulan')->nullable();
            $table->string('tahun_pelaksanaan');
            $table->integer('lama_kegiatan')->nullable();
            $table->string('bidang_fokus')->nullable();
            $table->bigInteger('dana_diusulkan')->nullable();
            $table->bigInteger('dana_disetujui')->nullable();
            $table->string('nama_institusi_penerima_dana')->nullable();
            $table->integer('target_tkt')->nullable();
            $table->string('nama_program_hibah')->nullable();
            $table->string('kategori_sumber_dana')->nullable();
            $table->string('negara_sumber_dana')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->foreignId('id_dosen')->nullable()->constrained('data_dosen');
            $table->string('nama_ketua')->nullable();
            $table->bigInteger('dana_ketua')->nullable();
            $table->string('pt')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penelitian_main');
    }
};
