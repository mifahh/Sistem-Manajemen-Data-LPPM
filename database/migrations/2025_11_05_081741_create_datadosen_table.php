<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/[timestamp]_create_datadosen_table.php
    public function up()
    {
        Schema::create('data_dosen', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dosen')->unique();
            $table->boolean('status_aktif');
            $table->string('prodi')->nullable();
            $table->string('nip', 10)->nullable()->unique();
            $table->string('nidn', 10)->nullable();
            $table->string('coe')->nullable();
            $table->string('kk')->nullable();
            $table->string('kode', 5)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_dosen');
    }
};
