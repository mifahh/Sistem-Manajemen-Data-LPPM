<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterKKSeeder extends Seeder
{
    public function run(): void
    {
        // Seed using fixed jurusan list
        $kk = [
            "Smart Computing Technology (SCOUT)",
            "ETHES (Electrical Engineering and Advanced Technologies)",
            "Rekayasa Industri dan Inovasi Bisnis (RIIB)",
        ];

        foreach ($kk as $nama) {
            if (!DB::table('master_kk')->where('nama_kk', $nama)->exists()) {
                DB::table('master_kk')->insert([
                    'nama_kk' => $nama,
                    'aktif' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
