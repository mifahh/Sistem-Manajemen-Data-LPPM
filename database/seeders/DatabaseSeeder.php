<?php

namespace Database\Seeders;

use App\Models\Publikasi;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ini_set('memory_limit', '2048M'); // atau 2G kalau perlu
        ini_set('max_execution_time', '300'); // 300 detik = 5 menit
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            MasterJurusanSeeder::class,
            MasterTahunSeeder::class,
            MasterCoESeeder::class,
            MasterKKSeeder::class,
            MasterKategoriKISeeder::class,
            DataDosenSeeder::class,
            DataMahasiswaSeeder::class,
            DataStaffSeeder::class,
            PublikasiSeeder::class,
        ]);
    }
}
