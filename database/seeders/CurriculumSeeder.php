<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curriculum;

class CurriculumSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'type'              => 'kmi',
                'name'              => "Kulliyatul Mu'allimin Al-Islamiyah (KMI)",
                'tagline'           => "Mencetak Pemimpin Umat Berlandaskan Al-Qur'an & Sunnah",
                'year_established'  => 2006,
                'total_students'    => null,
                'total_teachers'    => null,
                'head_name'         => 'KH. Syihabuddin Muhammad',
                'head_title'        => 'Pimpinan Pondok & Direktur KMI',
                'npsn'              => null,
                'nss'               => null,
                'accreditation'     => null,
                'accreditation_year'=> null,
                'operational_permit'=> null,
                'permit_date'       => null,
                'permit_issuer'     => null,
                'description'       => "Kulliyatul Mu'allimin Al-Islamiyah (KMI) adalah program inti Pondok Modern Al-Hikmah yang mengintegrasikan ilmu agama Islam (Dirasah Islamiyah) dengan ilmu umum secara seimbang dan terpadu. Kurikulum KMI mengacu pada sistem pendidikan Pondok Modern Darussalam Gontor yang telah terbukti melahirkan ulama, intelektual, dan pemimpin umat.",
                'history'           => "KMI Al-Hikmah mulai beroperasi sejak pondok didirikan pada 27 Juli 2006 oleh KH. Syihabuddin Muhammad, alumni Pondok Modern Darussalam Gontor. Program ini menggunakan metode pengajaran berbasis bahasa Arab dan Inggris sebagai bahasa pengantar sehari-hari, sehingga lulusannya memiliki kemampuan komunikasi internasional yang kuat. Pada tahun 2012, pondok berpindah lokasi ke Dusun Bina Marga, Desa Stowe Brang, Kecamatan Utan, Kabupaten Sumbawa, untuk mengembangkan kapasitas dan kualitas pendidikan.",
                'features'          => [
                    ['item' => 'Bahasa Pengantar: Arab & Inggris secara aktif'],
                    ['item' => 'Kajian Kitab Kuning (Turats) Dasar hingga Lanjutan'],
                    ['item' => 'Praktek Mengajar (Amaliyah Tadris) bagi kelas akhir'],
                    ['item' => 'Program Tahfidz Al-Quran terintegrasi'],
                    ['item' => 'Pendidikan Akhlak, Adab, dan Kepemimpinan'],
                    ['item' => 'Pidato 3 Bahasa (Indonesia, Arab, Inggris)'],
                ],
                'subjects'          => [
                    ['name' => "Al-Qur'an & Tajwid", 'type' => 'agama'],
                    ['name' => 'Tafsir & Ulumul Quran', 'type' => 'agama'],
                    ['name' => 'Hadits & Musthalah Hadits', 'type' => 'agama'],
                    ['name' => 'Fiqih & Ushul Fiqih', 'type' => 'agama'],
                    ['name' => 'Bahasa Arab (Nahwu, Sharaf, Balaghah)', 'type' => 'bahasa'],
                    ['name' => 'Bahasa Inggris', 'type' => 'bahasa'],
                    ['name' => 'Matematika', 'type' => 'umum'],
                    ['name' => 'Ilmu Pengetahuan Alam (IPA)', 'type' => 'umum'],
                    ['name' => 'Sejarah Islam & Peradaban', 'type' => 'agama'],
                    ['name' => 'Tarbiyah & Ilmu Pendidikan', 'type' => 'agama'],
                ],
                'achievements'      => [
                    ['title' => 'Juara Pidato Bahasa Arab Tingkat Provinsi NTB', 'year' => 2023, 'level' => 'Provinsi'],
                    ['title' => 'Juara Kaligrafi Islam Tingkat Kabupaten Sumbawa', 'year' => 2022, 'level' => 'Kabupaten'],
                ],
                'order'             => 1,
            ],
            [
                'type'              => 'smp',
                'name'              => 'SMP Al-Hikmah Utan Sumbawa',
                'tagline'           => 'Pendidikan Nasional Berwawasan Islam',
                'year_established'  => 2008,
                'total_students'    => null,
                'total_teachers'    => null,
                'head_name'         => null,
                'head_title'        => 'Kepala Sekolah SMP Al-Hikmah',
                'npsn'              => null,
                'nss'               => null,
                'accreditation'     => null,
                'accreditation_year'=> null,
                'operational_permit'=> null,
                'permit_date'       => null,
                'permit_issuer'     => 'Dinas Pendidikan & Kebudayaan Kab. Sumbawa',
                'description'       => 'SMP Al-Hikmah mengacu pada Kurikulum Nasional (Kemdikbud) yang diperkaya dengan muatan lokal kepesantrenan dan nilai-nilai Islam. Santri memperoleh pendidikan formal setara dengan sekolah negeri, sekaligus dibimbing dengan program keagamaan pondok pesantren secara penuh.',
                'history'           => 'SMP Al-Hikmah mulai beroperasi beberapa tahun setelah berdirinya pondok, sebagai jenjang pendidikan formal pertama yang dibuka untuk mengakomodasi santri lulusan SD/MI yang ingin mendapatkan ijazah formal setara Sekolah Menengah Pertama sekaligus menempuh pendidikan pesantren secara penuh.',
                'features'          => [
                    ['item' => 'Kurikulum Nasional (Kemdikbud) Terakreditasi'],
                    ['item' => 'Integrasi Nilai-nilai Islam dalam Semua Mata Pelajaran'],
                    ['item' => 'Pengembangan Bakat & Minat melalui Ekstrakurikuler'],
                    ['item' => 'Pramuka & Kegiatan Kepanduan Wajib'],
                    ['item' => 'Persiapan Ujian Nasional & Kelulusan'],
                    ['item' => 'Bimbingan Belajar & Remedial Intensif'],
                ],
                'subjects'          => [
                    ['name' => 'Pendidikan Agama Islam', 'type' => 'agama'],
                    ['name' => 'Bahasa Indonesia', 'type' => 'bahasa'],
                    ['name' => 'Bahasa Inggris', 'type' => 'bahasa'],
                    ['name' => 'Matematika', 'type' => 'umum'],
                    ['name' => 'IPA (Fisika, Biologi, Kimia)', 'type' => 'sains'],
                    ['name' => 'IPS (Geografi, Sejarah, Ekonomi)', 'type' => 'umum'],
                    ['name' => 'PKN', 'type' => 'umum'],
                    ['name' => 'Seni Budaya', 'type' => 'umum'],
                    ['name' => 'Penjaskes', 'type' => 'umum'],
                    ['name' => 'Bahasa Arab (Muatan Lokal)', 'type' => 'bahasa'],
                ],
                'achievements'      => [],
                'order'             => 2,
            ],
            [
                'type'              => 'ma',
                'name'              => 'Madrasah Aliyah (MA) Al-Hikmah',
                'tagline'           => 'Mempersiapkan Generasi untuk Perguruan Tinggi & Pengabdian Umat',
                'year_established'  => 2010,
                'total_students'    => null,
                'total_teachers'    => null,
                'head_name'         => null,
                'head_title'        => 'Kepala Madrasah Aliyah Al-Hikmah',
                'npsn'              => null,
                'nss'               => null,
                'accreditation'     => null,
                'accreditation_year'=> null,
                'operational_permit'=> null,
                'permit_date'       => null,
                'permit_issuer'     => 'Kementerian Agama (Kemenag) Kab. Sumbawa',
                'description'       => 'Madrasah Aliyah (MA) Al-Hikmah mengacu pada Kurikulum Kementerian Agama (Kemenag) yang dipadukan dengan Kurikulum KMI Pondok Modern. Lulusannya dipersiapkan untuk dapat melanjutkan pendidikan ke perguruan tinggi negeri maupun luar negeri (Timur Tengah, Malaysia, dll) dengan bekal ilmu agama dan umum yang kuat.',
                'history'           => 'MA Al-Hikmah didirikan sebagai jenjang lanjutan dari SMP Al-Hikmah untuk memberikan kesempatan kepada santri agar mendapatkan ijazah formal setingkat SMA/SMK yang diakui oleh Kemenag, sehingga lulusan dapat langsung mendaftar ke perguruan tinggi dalam dan luar negeri tanpa hambatan administratif.',
                'features'          => [
                    ['item' => 'Kurikulum Kemenag Terintegrasi dengan KMI'],
                    ['item' => 'Jurusan IPA & IPS'],
                    ['item' => 'Persiapan SNBT/Ujian Mandiri Perguruan Tinggi'],
                    ['item' => 'Bimbingan Beasiswa ke Timur Tengah & Dalam Negeri'],
                    ['item' => 'Kajian Fiqih, Tafsir & Hadits Lanjutan'],
                    ['item' => 'Program Intensif Bahasa Arab & Inggris'],
                ],
                'subjects'          => [
                    ['name' => 'Al-Qur\'an Hadits', 'type' => 'agama'],
                    ['name' => 'Aqidah Akhlak', 'type' => 'agama'],
                    ['name' => 'Fiqih', 'type' => 'agama'],
                    ['name' => 'Sejarah Kebudayaan Islam (SKI)', 'type' => 'agama'],
                    ['name' => 'Bahasa Arab', 'type' => 'bahasa'],
                    ['name' => 'Bahasa Indonesia', 'type' => 'bahasa'],
                    ['name' => 'Bahasa Inggris', 'type' => 'bahasa'],
                    ['name' => 'Matematika (Wajib & Peminatan)', 'type' => 'umum'],
                    ['name' => 'Fisika / Geografi (Peminatan)', 'type' => 'sains'],
                    ['name' => 'Kimia / Ekonomi (Peminatan)', 'type' => 'sains'],
                    ['name' => 'Biologi / Sosiologi (Peminatan)', 'type' => 'sains'],
                    ['name' => 'PKN & Sejarah Indonesia', 'type' => 'umum'],
                ],
                'achievements'      => [],
                'order'             => 3,
            ],
        ];

        foreach ($data as $item) {
            Curriculum::firstOrCreate(['type' => $item['type']], $item);
        }
    }
}
