<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,          // 1. Users dulu
            SimpananSeeder::class,      // 2. Simpanan (butuh user)
            TabunganSeeder::class,      // 3. Tabungan + Mutasi (butuh user)
            PinjamanSeeder::class,      // 4. Pinjaman (butuh user)
            BayarPinjamanSeeder::class, // 5. Bayar Pinjaman (butuh pinjaman)
        ]);
    }
}