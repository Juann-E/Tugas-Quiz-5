<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Demo user untuk testing
        User::create([
            'nama_lengkap' => 'Admin Demo',
            'username'     => 'demo',
            'password'     => Hash::make('demo123'),
            'saldo'        => 500000,
        ]);
    }
}
