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
        Schema::create('data_ki', function (Blueprint $table) {
            $table->id();
            $table->string('application_number')->nullable();
            $table->string('kategori')->nullable();
            $table->integer('application_year')->nullable();
            $table->string('title')->nullable();
            $table->string('jenis_hki')->nullable();
            $table->string('prototype')->nullable();
            $table->string('patent_holder')->nullable();
            $table->foreignId('id_dosen')->nullable()->constrained('data_dosen');
            $table->string('inventor')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('prodi')->nullable();
            $table->string('publication_number')->nullable();
            $table->string('publication_link')->nullable();
            $table->date('publication_date')->nullable();
            $table->date('filling_date')->nullable();
            $table->date('reception_date')->nullable();
            $table->date('registration_date')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('status')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_ki');
    }
};
