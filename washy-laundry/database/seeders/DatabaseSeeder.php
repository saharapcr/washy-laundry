<?php

namespace Database\Seeders;

use App\Models\{User, Service, LaundryOrder, OrderDetail, Payment};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create(['name' => 'Admin Washy', 'email' => 'admin@washy.test',
            'password' => Hash::make('password'), 'role' => 'admin']);

        $sahara = User::create(['name' => 'Sahara Putri', 'email' => 'sahara@email.com',
            'password' => Hash::make('password'), 'role' => 'pelanggan',
            'no_telepon' => '0812 3456 7890', 'alamat' => 'Jl. Melati No. 12']);
        $dina = User::create(['name' => 'Dina Amelia', 'email' => 'dina@email.com',
            'password' => Hash::make('password'), 'no_telepon' => '0813 1111 2222', 'alamat' => 'Jl. Mawar No. 3']);
        $rizky = User::create(['name' => 'Rizky Pratama', 'email' => 'rizky@email.com',
            'password' => Hash::make('password'), 'no_telepon' => '0814 3333 4444', 'alamat' => 'Jl. Anggrek No. 8']);

        $S = [
            'komplit' => Service::create(['nama_layanan' => 'Cuci komplit', 'harga_perkg' => 8000, 'durasi_hari' => 2, 'deskripsi' => 'Cuci, kering, dan setrika']),
            'kering'  => Service::create(['nama_layanan' => 'Cuci kering', 'harga_perkg' => 6000, 'durasi_hari' => 2, 'deskripsi' => 'Cuci dan kering']),
            'setrika' => Service::create(['nama_layanan' => 'Setrika', 'harga_perkg' => 5000, 'durasi_hari' => 1, 'deskripsi' => 'Setrika saja']),
            'express' => Service::create(['nama_layanan' => 'Express', 'harga_perkg' => 12000, 'durasi_hari' => 1, 'deskripsi' => 'Selesai 1 hari']),
        ];

        $data = [
            [$sahara, 'komplit', 4.5, 'Sedang dicuci', 0],
            [$dina, 'kering', 3, 'Selesai', 4],
            [$rizky, 'setrika', 2, 'Selesai', 4],
            [$sahara, 'komplit', 5, 'Selesai', 9],
        ];

        foreach ($data as $i => [$user, $key, $berat, $status, $hariLalu]) {
            $s = $S[$key];
            $total = (int) round($s->harga_perkg * $berat);
            $o = LaundryOrder::create([
                'user_id' => $user->id,
                'kode' => 'WSH-' . str_pad(248 - $i, 4, '0', STR_PAD_LEFT),
                'total_harga' => $total,
                'tanggal_pesanan' => now()->subDays($hariLalu),
                'estimasi_selesai' => now()->setTime(16, 30),
                'status_pesanan' => $status,
                'alamat_jemput' => $user->alamat,
                'kurir' => 'Budi Santoso',
            ]);
            OrderDetail::create(['laundry_order_id' => $o->id, 'service_id' => $s->id,
                'berat_kg' => $berat, 'harga_perkg' => $s->harga_perkg, 'subtotal' => $total]);
            Payment::create(['laundry_order_id' => $o->id, 'jumlah_bayar' => $total,
                'status_pembayaran' => $status === 'Selesai' ? 'Berhasil' : 'Menunggu',
                'tanggal_pembayaran' => $status === 'Selesai' ? now() : null]);
        }
    }
}
