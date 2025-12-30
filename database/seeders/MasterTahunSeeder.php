<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterTahunSeeder extends Seeder
{
    public function run(): void
    {
        // Seed years 2018 hingga tahun berjalan
        $years = collect(range(2018, now()->year));

        foreach ($years as $tahun) {
            if (!DB::table('master_tahun')->where('tahun', $tahun)->exists()) {
                DB::table('master_tahun')->insert([
                    'tahun' => (int) $tahun,
                    'aktif' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
