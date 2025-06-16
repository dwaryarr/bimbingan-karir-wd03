<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polis = [
            [
                'nama' => 'Poli Umum',
                'deskripsi' => 'Pelayanan kesehatan umum untuk semua pasien.',
            ],
            [
                'nama' => 'Poli Gigi',
                'deskripsi' => 'Pelayanan kesehatan gigi dan mulut.',
            ],
            [
                'nama' => 'Poli Anak',
                'deskripsi' => 'Pelayanan kesehatan khusus untuk anak-anak.',
            ],
            [
                'nama' => 'Poli Kandungan dan Kebidanan',
                'deskripsi' => 'Pelayanan kesehatan ibu hamil dan kandungan.',
            ],
            [
                'nama' => 'Poli THT',
                'deskripsi' => 'Pelayanan kesehatan telinga, hidung, dan tenggorokan.',
            ],
            [
                'nama' => 'Poli Mata',
                'deskripsi' => 'Pelayanan kesehatan mata.',
            ],
            [
                'nama' => 'Poli Penyakit Dalam',
                'deskripsi' => 'Pelayanan kesehatan untuk penyakit dalam (internis).',
            ],
        ];

        foreach ($polis as $poli) {
            Poli::create([
                'nama' => $poli['nama'],
                'deskripsi' => $poli['deskripsi'],
            ]);
        }
    }
}
