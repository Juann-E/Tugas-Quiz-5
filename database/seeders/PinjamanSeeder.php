<?php

namespace Database\Seeders;

use App\Models\pinjaman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PinjamanSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $statuses = ['menunggu', 'disetujui', 'ditolak', 'lunas'];

        foreach ($users as $user) {
            $count = rand(1, 3);

            for ($i = 1; $i <= $count; $i++) {
                $pokok = rand(5000000, 50000000);
                $bunga = rand(1, 3);
                $tenor = rand(6, 24);
                $totalBunga = ($pokok * $bunga * $tenor) / 100;
                $totalBayar = $pokok + $totalBunga;
                $angsuran = $totalBayar / $tenor;

                pinjaman::create([
                    'user_id' => $user->id,
                    'kode_pinjaman' => 'PIN-' . str_pad(pinjaman::count() + 1, 4, '0', STR_PAD_LEFT),
                    'jumlah_pinjaman' => $pokok,
                    'bunga_persen' => $bunga,
                    'tenor_bulan' => $tenor,
                    'angsuran_per_bulan' => $angsuran,
                    'total_bayar' => $totalBayar,
                    'sisa_pinjaman' => $totalBayar - (rand(0, 3) * $angsuran),
                    'tanggal_pengajuan' => Carbon::now()->subDays(rand(10, 120)),
                    'tanggal_disetujui' => Carbon::now()->subDays(rand(5, 100)),
                    'status' => $statuses[array_rand($statuses)],
                    'tujuan_pinjaman' => 'Pengembangan usaha',
                    'keterangan' => 'Pinjaman untuk keperluan bisnis',
                ]);
            }
        }
    }
}
