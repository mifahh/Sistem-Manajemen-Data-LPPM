<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterCoESeeder extends Seeder
{
    public function run(): void
    {
        // Seed using fixed jurusan list
        $coe = [
            "Intergrated and Embedded Systems",
            "Motion Technology for Safety, Health, and Wellness",
            "Circular Ecosystem and Sustainable Technology",
        ];

        foreach ($coe as $nama) {
            if (!DB::table('master_coe')->where('nama_coe', $nama)->exists()) {
                DB::table('master_coe')->insert([
                    'nama_coe' => $nama,
                    'aktif' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
