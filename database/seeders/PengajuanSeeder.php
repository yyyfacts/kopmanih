<?php

namespace Database\Seeders;

use App\Models\Pengajuan;
use Illuminate\Database\Seeder;

class PengajuanSeeder extends Seeder
{
    public function run(): void
    {
        Pengajuan::insert([
            [
                'nama_barang' => 'Projector',
                'urgensi' => 5,
                'stok' => 2,
                'anggaran' => 1500000,
                'user_id' => 1,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_barang' => 'Mikrofon',
                'urgensi' => 4,
                'stok' => 4,
                'anggaran' => 500000,
                'user_id' => 1,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_barang' => 'Kursi Jemaat',
                'urgensi' => 3,
                'stok' => 20,
                'anggaran' => 3000000,
                'user_id' => 1,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_barang' => 'Kabel Sound',
                'urgensi' => 4,
                'stok' => 1,
                'anggaran' => 200000,
                'user_id' => 1,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
