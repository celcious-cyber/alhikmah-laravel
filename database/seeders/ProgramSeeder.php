<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'title' => 'Kelas 6 KMI',
                'category' => 'Kelas V & VI',
                'description' => 'Masa bimbingan akhir, praktek mengajar (Amaliyah Tadris), dan persiapan pengabdian ke masyarakat.',
                'order' => 1
            ],
            [
                'title' => 'Kelas 5 KMI',
                'category' => 'Kelas V & VI',
                'description' => 'Estafet kepemimpinan organisasi pondok (OPPH) dan kepanitiaan berbagai acara besar santri.',
                'order' => 2
            ],
            [
                'title' => 'Tahfidz Al-Quran',
                'category' => 'Ekstrakurikuler',
                'description' => 'Program menghafal Al-Quran dengan metode karantina, murajaah rutin, dan pembinaan tajwid bersanad.',
                'order' => 3
            ],
            [
                'title' => 'Ekstrakurikuler Umum',
                'category' => 'Ekstrakurikuler',
                'description' => 'Pengembangan minat bakat melalui klub olahraga, bahasa, kesenian, jurnalistik, dan keterampilan.',
                'order' => 4
            ],
            [
                'title' => 'Pramuka',
                'category' => 'Ekstrakurikuler',
                'description' => 'Kegiatan kepanduan wajib untuk membentuk karakter mandiri, disiplin, ketangkasan, dan cinta alam.',
                'order' => 5
            ],
            [
                'title' => 'OPPH',
                'category' => 'Ekstrakurikuler',
                'description' => 'Organisasi Pelajar Pondok Hikmah sebagai laboratorium nyata kepemimpinan dan manajemen santri.',
                'order' => 6
            ]
        ];

        foreach ($programs as $p) {
            \App\Models\Program::firstOrCreate(['title' => $p['title']], $p);
        }
    }
}
