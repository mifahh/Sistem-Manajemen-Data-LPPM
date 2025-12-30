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
        Schema::create('abdimas_luaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_abdimas')->constrained('abdimas_main')->cascadeOnDelete();

            // Luaran information
            $table->text('publikasi_ilmiah')->nullable();
            $table->text('media_massa')->nullable();
            $table->text('produk_jasa')->nullable();
            $table->text('capaian_publikasi_ilmiah')->nullable();
            $table->text('capaian_luaran_wajib')->nullable();
            $table->text('luaran_tambahan')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abdimas_luaran');
    }
};
