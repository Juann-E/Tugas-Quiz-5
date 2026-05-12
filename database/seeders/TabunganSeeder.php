<?php

namespace Database\Seeders;

use App\Models\tabungan;
use App\Models\User;
use App\Models\MutasiTabungan;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TabunganSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $tabungan = tabungan::create([
                'user_id' => $user->id,
                'no_rekening' => 'REK-' . str_pad(tabungan::count() + 1, 4, '0', STR_PAD_LEFT),
                'saldo' => rand(1000000, 50000000),
                'status' => 'aktif',
            ]);

            // Create transaction history (mutasi)
            for ($i = 0; $i < rand(5, 15); $i++) {
                $jenis = rand(0, 1) ? 'setor' : 'tarik';
                $jumlah = rand(100000, 2000000);
                $saldoSebelum = $tabungan->saldo - ($i * rand(500000, 1000000));
                $saldoSesudah = $jenis === 'setor' 
                    ? $saldoSebelum + $jumlah 
                    : $saldoSebelum - $jumlah;

                MutasiTabungan::create([
                    'tabungan_id' => $tabungan->id,
                    'jenis' => $jenis,
                    'jumlah' => $jumlah,
                    'saldo_sebelum' => $saldoSebelum,
                    'saldo_sesudah' => $saldoSesudah,
                    'tanggal_transaksi' => Carbon::now()->subDays(rand(1, 60)),
                    'keterangan' => ucfirst($jenis) . ' transaksi',
                ]);
            }
        }
    }
}
