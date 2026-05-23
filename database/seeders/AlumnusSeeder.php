<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumnus;

class AlumnusSeeder extends Seeder
{
    public function run(): void
    {
        $alumni = [
            [
                'name' => 'Ahmad Fauzi',
                'graduation_year' => 2018,
                'university' => 'Universitas Al-Azhar',
                'country' => 'Mesir',
                'major' => 'Syariah Islamiyyah',
                'profession' => 'Mahasiswa Pascasarjana',
                'testimony' => 'Pondok Modern Al-Hikmah memberikan fondasi bahasa Arab dan agama yang sangat kuat, sehingga sangat memudahkan saya saat melanjutkan studi di Timur Tengah.',
                'is_featured' => true,
            ],
            [
                'name' => 'Budi Santoso',
                'graduation_year' => 2019,
                'university' => 'Universitas Gadjah Mada',
                'country' => 'Indonesia',
                'major' => 'Teknik Informatika',
                'profession' => 'Software Engineer di Startup Nasional',
                'testimony' => 'Disiplin waktu dan kepemimpinan yang diajarkan di pondok sangat berguna di dunia kerja profesional.',
                'is_featured' => true,
            ],
            [
                'name' => 'Siti Aminah',
                'graduation_year' => 2020,
                'university' => 'Marmara University',
                'country' => 'Turki',
                'major' => 'Ilmu Ekonomi Islam',
                'profession' => 'Mahasiswi',
                'testimony' => 'Saya bangga menjadi bagian dari IKPH. Jaringan alumni yang tersebar di berbagai negara sangat membantu saat awal merantau.',
                'is_featured' => true,
            ],
            [
                'name' => 'Muhammad Ridwan',
                'graduation_year' => 2017,
                'university' => 'Universitas Islam Madinah',
                'country' => 'Arab Saudi',
                'major' => 'Hadits',
                'profession' => 'Pendakwah / Ustadz',
                'testimony' => 'Hafalan Al-Quran dan bekal ilmu diniyah dari Al-Hikmah adalah modal utama saya bisa diterima di Madinah.',
                'is_featured' => true,
            ],
            [
                'name' => 'Rina Wijayanti',
                'graduation_year' => 2021,
                'university' => 'Universitas Indonesia',
                'country' => 'Indonesia',
                'major' => 'Ilmu Kedokteran',
                'profession' => 'Dokter Muda',
                'testimony' => 'Siapa bilang anak pesantren tidak bisa jadi dokter? Pondok Al-Hikmah membuktikan kurikulum umumnya juga berdaya saing tinggi.',
                'is_featured' => true,
            ],
            [
                'name' => 'Zayed Al-Fatih',
                'graduation_year' => 2020,
                'university' => 'International Islamic University Malaysia (IIUM)',
                'country' => 'Malaysia',
                'major' => 'Hubungan Internasional',
                'profession' => 'Mahasiswa',
                'testimony' => 'Bahasa Inggris yang dilatih setiap hari di pondok sangat menunjang studi internasional saya.',
                'is_featured' => false,
            ],
        ];

        foreach ($alumni as $alumnus) {
            Alumnus::create($alumnus);
        }
    }
}
