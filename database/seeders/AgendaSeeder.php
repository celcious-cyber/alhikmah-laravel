<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agenda;

class AgendaSeeder extends Seeder
{
    public function run(): void
    {
        $agendas = [
            // Harian
            ['type' => 'harian', 'title' => 'Bangun Tidur & Persiapan Shalat Subuh', 'time' => '04:00 - 04:30', 'description' => 'Santri bangun, mandi, dan menuju masjid untuk persiapan shalat.', 'order' => 1],
            ['type' => 'harian', 'title' => 'Shalat Subuh Berjamaah & Tadarus', 'time' => '04:30 - 05:30', 'description' => 'Shalat Subuh berjamaah dilanjutkan dengan tadarus Al-Quran dan pemberian mufradat (kosa kata) bahasa Arab/Inggris.', 'order' => 2],
            ['type' => 'harian', 'title' => 'Mandi & Sarapan Pagi', 'time' => '05:30 - 06:45', 'description' => 'Persiapan berangkat ke sekolah dan sarapan pagi di dapur umum.', 'order' => 3],
            ['type' => 'harian', 'title' => 'Masuk Kelas (KBM Pagi)', 'time' => '07:00 - 12:30', 'description' => 'Kegiatan Belajar Mengajar (KBM) di kelas masing-masing.', 'order' => 4],
            ['type' => 'harian', 'title' => 'Shalat Dzuhur & Makan Siang', 'time' => '12:30 - 14:00', 'description' => 'Shalat Dzuhur berjamaah dilanjutkan makan siang dan istirahat sejenak.', 'order' => 5],
            ['type' => 'harian', 'title' => 'KBM Sore / Ekstrakurikuler', 'time' => '14:00 - 15:15', 'description' => 'Melanjutkan pelajaran atau kegiatan ekstrakurikuler pilihan.', 'order' => 6],
            ['type' => 'harian', 'title' => 'Shalat Ashar & Olahraga', 'time' => '15:15 - 17:00', 'description' => 'Shalat Ashar berjamaah, dilanjutkan olahraga atau kegiatan bebas terarah.', 'order' => 7],
            ['type' => 'harian', 'title' => 'Mandi Sore & Persiapan Maghrib', 'time' => '17:00 - 18:00', 'description' => 'Mandi dan bersiap menuju masjid sebelum adzan berkumandang.', 'order' => 8],
            ['type' => 'harian', 'title' => 'Shalat Maghrib & Baca Al-Quran', 'time' => '18:00 - 19:30', 'description' => 'Shalat Maghrib berjamaah dan halaqah tahfidz / bimbingan membaca Al-Quran.', 'order' => 9],
            ['type' => 'harian', 'title' => 'Shalat Isya & Makan Malam', 'time' => '19:30 - 20:30', 'description' => 'Shalat Isya berjamaah dan makan malam.', 'order' => 10],
            ['type' => 'harian', 'title' => 'Belajar Malam (Tawajjuh)', 'time' => '20:30 - 22:00', 'description' => 'Belajar mandiri terbimbing (muwajjah) untuk mengulang pelajaran dan mengerjakan tugas.', 'order' => 11],
            ['type' => 'harian', 'title' => 'Tidur Malam', 'time' => '22:00 - 04:00', 'description' => 'Istirahat malam wajib bagi seluruh santri.', 'order' => 12],

            // Mingguan
            ['type' => 'mingguan', 'title' => 'Muhadharah (Latihan Pidato)', 'time' => 'Kamis & Ahad Malam', 'description' => 'Latihan pidato 3 bahasa (Indonesia, Arab, Inggris) secara bergilir.', 'order' => 1],
            ['type' => 'mingguan', 'title' => 'Lari Pagi / Lintas Alam', 'time' => 'Jumat Pagi', 'description' => 'Olahraga lari pagi atau jalan sehat mengelilingi desa atau area pondok.', 'order' => 2],
            ['type' => 'mingguan', 'title' => 'Pembersihan Umum (Ro\'an)', 'time' => 'Jumat Pagi', 'description' => 'Kerja bakti membersihkan asrama, kelas, masjid, dan lingkungan pondok.', 'order' => 3],
            ['type' => 'mingguan', 'title' => 'Latihan Pramuka', 'time' => 'Kamis Sore', 'description' => 'Kegiatan kepanduan wajib bagi seluruh santri.', 'order' => 4],
            ['type' => 'mingguan', 'title' => 'Pemberian Mufradat Mingguan', 'time' => 'Ahad Pagi', 'description' => 'Evaluasi dan penambahan kosa kata bahasa Arab/Inggris baru.', 'order' => 5],

            // Bulanan
            ['type' => 'bulanan', 'title' => 'Ujian Bulanan (Ulangan Umum)', 'time' => 'Akhir Bulan', 'description' => 'Evaluasi hasil belajar selama satu bulan.', 'order' => 1],
            ['type' => 'bulanan', 'title' => 'Pergantian Pengurus OPPH', 'time' => 'Sesuai Jadwal', 'description' => 'Rotasi atau evaluasi kepengurusan Organisasi Pelajar Pondok Modern Al-Hikmah (OPPH).', 'order' => 2],
            ['type' => 'bulanan', 'title' => 'Puasa Sunnah Ayyamul Bidh', 'time' => 'Tanggal 13, 14, 15 Hijriyah', 'description' => 'Anjuran dan bimbingan puasa sunnah pertengahan bulan qamariyah.', 'order' => 3],

            // Tahunan
            ['type' => 'tahunan', 'title' => 'Pekan Perkenalan Khutbatul Arsy', 'time' => 'Awal Tahun Ajaran', 'description' => 'Masa orientasi dan perkenalan pondok bagi santri baru dan lama.', 'order' => 1],
            ['type' => 'tahunan', 'title' => 'Ujian Semester Gasal & Genap', 'time' => 'Desember & Juni', 'description' => 'Ujian tulis dan lisan untuk evaluasi akademik semester.', 'order' => 2],
            ['type' => 'tahunan', 'title' => 'Perkemahan Khutbatul Arsy (PERKHA)', 'time' => 'Agustus / September', 'description' => 'Kegiatan perkemahan pramuka akbar tingkat pondok.', 'order' => 3],
            ['type' => 'tahunan', 'title' => 'Panggung Gembira (PG)', 'time' => 'Akhir Tahun', 'description' => 'Pagelaran seni akbar sebagai puncak kreativitas santri kelas akhir.', 'order' => 4],
            ['type' => 'tahunan', 'title' => 'Amaliyah Tadris (Praktek Mengajar)', 'time' => 'Semester 2', 'description' => 'Praktek mengajar wajib bagi santri kelas akhir KMI.', 'order' => 5],
            ['type' => 'tahunan', 'title' => 'Rihlah / Study Tour', 'time' => 'Liburan Semester', 'description' => 'Kegiatan edukasi dan rekreasi ke berbagai destinasi.', 'order' => 6],
        ];

        foreach ($agendas as $agenda) {
            Agenda::create($agenda);
        }
    }
}
