<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterJurusanSeeder extends Seeder
{
    public function run(): void
    {
        // Seed using fixed jurusan list
        $jurusan = [
            "Digital Bisnis",
            "Informatika",
            "Rekayasa Perangkat Lunak",
            "Sains Data",
            "Sistem Informasi",
            "Teknik Elektro",
            "Teknik Industri",
            "Teknik Komputer",
            "Teknik Logistik",
            "Teknik Telekomunikasi",
            "Teknologi Informasi"
        ];

        foreach ($jurusan as $nama) {
            if (!DB::table('master_jurusan')->where('nama_jurusan', $nama)->exists()) {
                DB::table('master_jurusan')->insert([
                    'nama_jurusan' => $nama,
                    'aktif' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
