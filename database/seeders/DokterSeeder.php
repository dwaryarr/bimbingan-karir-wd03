<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dokters = [
            [
                'nama' => 'Dr. Budi Santoso, Sp.PD',
                'email' => 'budi.santoso@klinik.com',
                'password' => Hash::make('12345678'),
                'role' => 'dokter',
                'alamat' => 'Jl. Pahlawan No. 123, Jakarta Selatan',
                'no_ktp' => '3175062505800001',
                'no_hp' => '081234567890',
                'id_poli' => 7, // Poli Penyakit Dalam
            ],
            [
                'nama' => 'Dr. Siti Rahayu, Sp.A',
                'email' => 'siti.rahayu@klinik.com',
                'password' => Hash::make('12345678'),
                'role' => 'dokter',
                'alamat' => 'Jl. Anggrek No. 45, Jakarta Pusat',
                'no_ktp' => '3175064610790002',
                'no_hp' => '081234567891',
                'id_poli' => 3, // Poli Anak
            ],
            [
                'nama' => 'Dr. Ahmad Wijaya, Sp.OG',
                'email' => 'ahmad.wijaya@klinik.com',
                'password' => Hash::make('12345678'),
                'role' => 'dokter',
                'alamat' => 'Jl. Melati No. 78, Jakarta Barat',
                'no_ktp' => '3175061505780003',
                'no_hp' => '081234567892',
                'id_poli' => 4, // Poli Kandungan dan Kebidanan
            ],
            [
                'nama' => 'Dr. Rina Putri, Sp.M',
                'email' => 'rina.putri@klinik.com',
                'password' => Hash::make('12345678'),
                'role' => 'dokter',
                'alamat' => 'Jl. Dahlia No. 32, Jakarta Timur',
                'no_ktp' => '3175062708850004',
                'no_hp' => '081234567893',
                'id_poli' => 6, // Poli Mata
            ],
            [
                'nama' => 'Dr. Doni Pratama, Sp.THT',
                'email' => 'doni.pratama@klinik.com',
                'password' => Hash::make('12345678'),
                'role' => 'dokter',
                'alamat' => 'Jl. Kenanga No. 56, Jakarta Utara',
                'no_ktp' => '3175061002820005',
                'no_hp' => '081234567894',
                'id_poli' => 5, // Poli THT
            ],
        ];

        foreach ($dokters as $dokter) {
            User::create($dokter);
        }
    }
}
