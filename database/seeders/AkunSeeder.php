<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@mail.com',
                'telp' => '0812-3456-7890',
                'level_role' => 'admin',
                'email_verified_at' => now(),
                'password' => bcrypt('admin123'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'ferdian',
                'email' => 'ferdian@mail.com',
                'telp' => '0812-3456-3333',
                'level_role' => 'pasien',
                'email_verified_at' => now(),
                'password' => bcrypt('ferdian123'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'narwan',
                'email' => 'arjutamanarwan@mail.com',
                'telp' => '0812-3456-4444',
                'level_role' => 'dokter',
                'email_verified_at' => now(),
                'password' => bcrypt('narwan123'),
                'remember_token' => Str::random(10),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
