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
        Schema::create('abdimas_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_abdimas')->constrained('abdimas_main')->cascadeOnDelete();

            // Member information
            $table->foreignId('id_dosen')->nullable()->constrained('data_dosen');
            $table->string('nama_member')->nullable();
            $table->bigInteger('dana_member')->nullable();
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
        Schema::dropIfExists('abdimas_members');
    }
};
