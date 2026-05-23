<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'title_id' => 'Kurikulum Terpadu',
                'desc_id' => 'Perpaduan harmonis antara kurikulum nasional dan kurikulum pesantren modern.',
                'title_en' => 'Integrated Curriculum',
                'desc_en' => 'A harmonious blend of the national curriculum and modern Islamic boarding school curriculum.',
                'icon' => 'BookOpen',
                'order' => 1
            ],
            [
                'title_id' => 'Hafalan Al-Quran',
                'desc_id' => 'Program tahfidz 30 juz dengan metode mutqin dan bimbingan ustadz berpengalaman.',
                'title_en' => 'Quran Memorization',
                'desc_en' => 'A 30-juz memorization program with mutqin methods and experienced tutors.',
                'icon' => 'BookMarked',
                'order' => 2
            ],
            [
                'title_id' => 'Fasilitas Modern',
                'desc_id' => 'Gedung asrama, laboratorium, perpustakaan, dan masjid yang nyaman dan memadai.',
                'title_en' => 'Modern Facilities',
                'desc_en' => 'Comfortable and adequate dormitories, laboratories, library, and mosque.',
                'icon' => 'Building',
                'order' => 3
            ],
            [
                'title_id' => 'Tenaga Ahli',
                'desc_id' => 'Dididik oleh para pengajar lulusan universitas ternama dan pondok pesantren terkemuka.',
                'title_en' => 'Expert Teachers',
                'desc_en' => 'Educated by graduates of top universities and leading Islamic boarding schools.',
                'icon' => 'Users',
                'order' => 4
            ],
            [
                'title_id' => 'Lingkungan Islami',
                'desc_id' => 'Suasana belajar yang kondusif untuk pembentukan karakter dan akhlakul karimah.',
                'title_en' => 'Islamic Environment',
                'desc_en' => 'A conducive learning atmosphere for character building and noble morals.',
                'icon' => 'Moon',
                'order' => 5
            ],
            [
                'title_id' => 'Prestasi Gemilang',
                'desc_id' => 'Mencetak santri berprestasi di tingkat nasional baik akademik maupun keagamaan.',
                'title_en' => 'Outstanding Achievements',
                'desc_en' => 'Producing students with national-level achievements in academics and religion.',
                'icon' => 'Trophy',
                'order' => 6
            ]
        ];

        foreach ($features as $f) {
            \App\Models\Feature::firstOrCreate(['title_id' => $f['title_id']], $f);
        }
    }
}
