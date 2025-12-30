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
        Schema::create('penelitian_additional_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penelitian')->constrained('penelitian_main')->cascadeOnDelete();

            // Additional fields
            $table->string('sdg')->nullable();
            $table->text('proposal')->nullable();
            $table->text('laporan_akhir')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penelitian_additional_fields');
    }
};
