<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleries = [
            [
                'imageUrl' => 'https://images.unsplash.com/photo-1577563908411-50cb98976fea?q=80&w=800&auto=format&fit=crop',
                'caption' => 'Pelajaran Kitab Kuning',
                'category' => 'Kegiatan',
                'order' => 1,
                'createdAt' => now(),
            ],
            [
                'imageUrl' => 'https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?q=80&w=800&auto=format&fit=crop',
                'caption' => 'Perkemahan Pramuka',
                'category' => 'Kegiatan',
                'order' => 2,
                'createdAt' => now(),
            ],
            [
                'imageUrl' => 'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?q=80&w=800&auto=format&fit=crop',
                'caption' => 'Masjid Jami Al-Hikmah',
                'category' => 'Fasilitas',
                'order' => 3,
                'createdAt' => now(),
            ],
            [
                'imageUrl' => 'https://images.unsplash.com/photo-1526676037777-05a232554f77?q=80&w=800&auto=format&fit=crop',
                'caption' => 'Juara Porseni',
                'category' => 'Prestasi',
                'order' => 4,
                'createdAt' => now(),
            ],
            [
                'imageUrl' => 'https://images.unsplash.com/photo-1588196749597-9ff0463923b7?q=80&w=800&auto=format&fit=crop',
                'caption' => 'Ujian Syafahi',
                'category' => 'Kegiatan',
                'order' => 5,
                'createdAt' => now(),
            ],
            [
                'imageUrl' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=800&auto=format&fit=crop',
                'caption' => 'Lab Komputer Baru',
                'category' => 'Fasilitas',
                'order' => 6,
                'createdAt' => now(),
            ],
            [
                'imageUrl' => 'https://images.unsplash.com/photo-1504164996022-09080787b6b3?q=80&w=800&auto=format&fit=crop',
                'caption' => 'Pelatihan Jurnalistik',
                'category' => 'Kegiatan',
                'order' => 7,
                'createdAt' => now(),
            ],
            [
                'imageUrl' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=800&auto=format&fit=crop',
                'caption' => 'Wisuda Tahfidz Qur\'an',
                'category' => 'Wisuda',
                'order' => 8,
                'createdAt' => now(),
            ],
            [
                'imageUrl' => 'https://images.unsplash.com/photo-1510531704581-5b28709e5054?q=80&w=800&auto=format&fit=crop',
                'caption' => 'Asrama Putra',
                'category' => 'Fasilitas',
                'order' => 9,
                'createdAt' => now(),
            ],
            [
                'imageUrl' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=800&auto=format&fit=crop',
                'caption' => 'Olimpiade Matematika',
                'category' => 'Prestasi',
                'order' => 10,
                'createdAt' => now(),
            ],
            [
                'imageUrl' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=800&auto=format&fit=crop',
                'caption' => 'Haflah Akhirussanah',
                'category' => 'Wisuda',
                'order' => 11,
                'createdAt' => now(),
            ],
            [
                'imageUrl' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=800&auto=format&fit=crop',
                'caption' => 'Robotik Al-Hikmah',
                'category' => 'Kegiatan',
                'order' => 12,
                'createdAt' => now(),
            ]
        ];

        DB::table('Gallery')->insert($galleries);
    }
}
