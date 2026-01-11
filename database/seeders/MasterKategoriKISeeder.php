<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterKategoriKISeeder extends Seeder
{
    public function run(): void
    {
        // Seed kategori KI
        $kategori = [
            [
                'nama_kategori' => 'Hak Cipta',
                'deskripsi' => 'Melindungi karya seni, sastra, musik, film, software, dan karya orisinal lainnya'
            ],
            [
                'nama_kategori' => 'Paten',
                'deskripsi' => 'Melindungi invensi teknis seperti alat, proses, atau formula yang baru dan berguna'
            ],
            [
                'nama_kategori' => 'Paten Sederhana',
                'deskripsi' => 'Melindungi invensi teknis seperti alat, proses, atau formula yang baru dan berguna'
            ],
            [
                'nama_kategori' => 'Merek',
                'deskripsi' => 'Melindungi identitas dagang seperti nama, logo, simbol, suara, atau warna produk'
            ],
            [
                'nama_kategori' => 'Desain Industri',
                'deskripsi' => 'Melindungi bentuk visual produk (tampilan luar) yang estetis dan baru'
            ],
            [
                'nama_kategori' => 'Rahasia Dagang',
                'deskripsi' => 'Melindungi identitas dagang seperti nama, logo, simbol, suara, atau warna produk'
            ],
            [
                'nama_kategori' => 'Indikasi Geografis',
                'deskripsi' => 'Melindungi produk khas daerah yang kualitasnya dipengaruhi oleh asal geografis'
            ],
            [
                'nama_kategori' => 'Desain Tata Letak Sirkuit Terpadu',
                'deskripsi' => 'Melindungi rancangan layout sirkuit elektronik yang orisinal dan fungsional'
            ],
        ];

        foreach ($kategori as $item) {
            if (!DB::table('master_kategori_ki')->where('nama_kategori', $item['nama_kategori'])->exists()) {
                DB::table('master_kategori_ki')->insert([
                    'nama_kategori' => $item['nama_kategori'],
                    'deskripsi' => $item['deskripsi'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
