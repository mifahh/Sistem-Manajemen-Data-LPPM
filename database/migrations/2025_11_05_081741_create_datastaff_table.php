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
        Schema::create('data_staff', function (Blueprint $table) {
            $table->id();
            $table->string('nama_staff')->unique();
            $table->boolean('status_aktif');
            $table->string('nip', 8)->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_staff');
    }
};
