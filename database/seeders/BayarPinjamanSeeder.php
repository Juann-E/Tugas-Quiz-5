<?php

namespace Database\Seeders;

use App\Models\bayar_pinjaman;
use App\Models\pinjaman;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BayarPinjamanSeeder extends Seeder
{
    public function run(): void
    {
        $pinjamans = pinjaman::where('status', 'disetujui')->get();
        $metodes = ['tunai', 'transfer'];

        foreach ($pinjamans as $p) {
            $keAngsuran = rand(1, $p->tenor_bulan);
            $sisaBerjalan = $p->total_bayar; // mulai dari total, bukan sisa_pinjaman

            for ($i = 1; $i <= $keAngsuran; $i++) {
                $bungaBayar  = ($p->jumlah_pinjaman * $p->bunga_persen) / 100;
                $pokokBayar  = $p->angsuran_per_bulan - $bungaBayar;
                $sisaBerjalan = max(0, $sisaBerjalan - $p->angsuran_per_bulan);

                bayar_pinjaman::create([
                    'pinjaman_id'        => $p->id,
                    'user_id'            => $p->user_id,
                    'kode_bayar'         => 'BAY-' . str_pad(bayar_pinjaman::count() + 1, 4, '0', STR_PAD_LEFT),
                    'ke_angsuran'        => $i,
                    'jumlah_bayar'       => $p->angsuran_per_bulan,
                    'pokok_bayar'        => $pokokBayar,
                    'bunga_bayar'        => $bungaBayar,
                    'sisa_setelah_bayar' => $sisaBerjalan,
                    'tanggal_bayar'      => Carbon::now()->subMonths($p->tenor_bulan - $i),
                    'metode_bayar'       => $metodes[array_rand($metodes)],
                    'keterangan'         => 'Pembayaran angsuran ke-' . $i,
                ]);
            }

            // Update sisa_pinjaman di tabel pinjaman sesuai hasil seeder
            $p->update(['sisa_pinjaman' => $sisaBerjalan]);
        }
    }
}
