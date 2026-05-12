<?php

namespace Database\Seeders;

use App\Models\simpanan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SimpananSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $jenisSimpanan = ['pokok', 'wajib', 'sukarela'];
            $count = rand(2, 4);

            for ($i = 1; $i <= $count; $i++) {
                simpanan::create([
                    'user_id' => $user->id,
                    'kode_simpanan' => 'SMP-' . str_pad(simpanan::count() + 1, 4, '0', STR_PAD_LEFT),
                    'jenis_simpanan' => $jenisSimpanan[array_rand($jenisSimpanan)],
                    'jumlah' => rand(100000, 5000000),
                    'tanggal_simpan' => Carbon::now()->subDays(rand(1, 90)),
                    'keterangan' => 'Simpanan periode ' . $i,
                ]);
            }
        }
    }
}
