<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterStatusKISeeder extends Seeder
{
    public function run(): void
    {
        $status = [
            [
                'nama_status' => 'Diajukan',
                'deskripsi' => 'Permohonan KI telah diajukan dan menunggu pemeriksaan administratif'
            ],
            [
                'nama_status' => 'Dalam Pemeriksaan',
                'deskripsi' => 'Permohonan KI sedang diperiksa oleh pihak berwenang'
            ],
            [
                'nama_status' => 'Granted',
                'deskripsi' => 'Hak KI telah diberikan secara resmi'
            ],
            [
                'nama_status' => '(PA) Diberi Paten',
                'deskripsi' => 'Hak KI telah diberikan secara resmi (Patent)'
            ],
            [
                'nama_status' => '(PA) Pemeriksaan Formalitas',
                'deskripsi' => 'Pemeriksaan formalitas permohonan paten'
            ],
            [
                'nama_status' => '(HC) Diberi Hak Cipta',
                'deskripsi' => 'Hak KI telah diberikan secara resmi (Copyright)'
            ],
            [
                'nama_status' => 'Ditolak',
                'deskripsi' => 'Permohonan KI ditolak karena tidak memenuhi syarat substantif atau administratif'
            ],
            [
                'nama_status' => 'Kadaluarsa',
                'deskripsi' => 'Hak KI sudah berakhir masa perlindungannya'
            ],
            [
                'nama_status' => 'Dibatalkan',
                'deskripsi' => 'Hak KI dibatalkan karena pelanggaran atau permintaan pemilik'
            ],
            [
                'nama_status' => 'Dalam Perpanjangan',
                'deskripsi' => 'Hak KI sedang dalam proses perpanjangan masa perlindungan'
            ],
        ];

        foreach ($status as $item) {
            if (!DB::table('master_status_ki')->where('nama_status', $item['nama_status'])->exists()) {
                DB::table('master_status_ki')->insert([
                    'nama_status' => $item['nama_status'],
                    'deskripsi' => $item['deskripsi'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
