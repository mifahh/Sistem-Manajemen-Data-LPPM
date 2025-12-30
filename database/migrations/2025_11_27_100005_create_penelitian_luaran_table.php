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
        Schema::create('penelitian_luaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penelitian')->constrained('penelitian_main')->cascadeOnDelete();

            // Luaran information
            $table->text('luaran_wajib')->nullable();
            $table->text('capaian_luaran_wajib')->nullable();
            $table->text('luaran_tambahan')->nullable();
            $table->text('capaian_luaran_tambahan')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penelitian_luaran');
    }
};
