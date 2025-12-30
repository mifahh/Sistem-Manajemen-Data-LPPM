<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AccountSeeder extends Seeder
{
    public function run()   
    {
        // Create default admin account if not exists
        $email = 'admin@example.com';
        $exists = DB::table('users')->where('email', $email)->exists();

        if (!$exists) {
            DB::table('users')->insert([
                'id' => 123456789,
                'name' => 'Admin',
                'email' => $email,
                'password' => bcrypt('admin123'), // bcrypt
                'no_hp' => '08123456789',
                'aktor_id' => '1',
                'keyword' => 'Admin@LPPM_2025',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
