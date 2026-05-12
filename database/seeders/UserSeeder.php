<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name_panjang' => 'Budi Santoso',  'username' => 'budi'],
            ['name_panjang' => 'Siti Rahayu',   'username' => 'siti'],
            ['name_panjang' => 'Agus Prasetyo', 'username' => 'agus'],
            ['name_panjang' => 'Dewi Lestari',  'username' => 'dewi'],
            ['name_panjang' => 'Eko Wahyudi',   'username' => 'eko'],
        ];

        foreach ($users as $u) {
            User::create([
                'name_panjang' => $u['name_panjang'],
                'username'     => $u['username'],
                'password'     => Hash::make('password'),
            ]);
        }
    }
}