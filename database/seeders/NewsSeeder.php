<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = [
            [
                'title' => 'Pondok Modern Al-Hikmah Raih Juara Umum MQK Tingkat Provinsi 2026',
                'slug' => Str::slug('Pondok Modern Al-Hikmah Raih Juara Umum MQK Tingkat Provinsi 2026'),
                'excerpt' => 'Kabar gembira datang dari kontingen santri Al-Hikmah yang berhasil menyabet gelar Juara Umum pada ajang Musabaqah Qira\'atil Kutub (MQK) ke-10 tingkat provinsi tahun ini.',
                'content' => '<p><strong>HUTAN, SUMBAWA</strong> — Kabar gembira datang dari kontingen santri Pondok Modern Al-Hikmah. Pada perhelatan Musabaqah Qira\'atil Kutub (MQK) ke-10 tingkat provinsi yang diselenggarakan akhir pekan lalu, para santri utusan pondok sukses mendulang prestasi dan meraih gelar Juara Umum.</p>
                              <p>Keberhasilan ini dicapai setelah para delegasi memenangkan berbagai kategori, mulai dari nahwu, sharf, fikih, hingga tafsir. Ustaz Ahmad, selaku pembimbing utama, menyampaikan rasa syukurnya. "Ini adalah hasil dari ketekunan santri dalam kegiatan *muthala\'ah* malam dan bimbingan intensif selama tiga bulan terakhir," ungkapnya.</p>
                              <p>Dengan raihan ini, Al-Hikmah berhak mewakili provinsi ke tingkat nasional yang akan digelar bulan depan di Jakarta. Pimpinan Pondok berpesan agar para santri tidak cepat puas dan terus menajamkan kemampuan literasi kitab kuning mereka.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1577563908411-50cb98976fea?q=80&w=1200&auto=format&fit=crop', // Islamic architecture/books
                'isPublished' => true,
                'createdAt' => now()->subDays(1),
                'updatedAt' => now()->subDays(1),
            ],
            [
                'title' => 'Pembukaan Pendaftaran Santri Baru (PSB) Gelombang Kedua Secara Daring',
                'slug' => Str::slug('Pembukaan Pendaftaran Santri Baru PSB Gelombang Kedua Secara Daring'),
                'excerpt' => 'Merespons tingginya antusiasme pendaftar, Panitia PSB Al-Hikmah resmi membuka pendaftaran gelombang kedua yang sepenuhnya dilakukan melalui portal digital.',
                'content' => '<p>Merespons tingginya antusiasme pendaftar pada gelombang pertama, Panitia Penerimaan Santri Baru (PSB) Pondok Modern Al-Hikmah secara resmi membuka pendaftaran gelombang kedua. Berbeda dari tahun-tahun sebelumnya, seluruh proses pendaftaran hingga ujian seleksi tahap awal akan dilaksanakan secara daring penuh.</p>
                              <p>Panitia menyediakan sistem yang terintegrasi di website sekolah, memungkinkan wali santri dari luar daerah bahkan luar pulau untuk mendaftarkan putra-putrinya tanpa harus hadir langsung ke pondok di tahap pemberkasan.</p>
                              <p>"Kami ingin memudahkan akses pendidikan berkualitas bagi semua kalangan," ujar Ketua Panitia PSB. Pendaftaran gelombang kedua ini akan ditutup pada akhir bulan berjalan atau apabila kuota telah terpenuhi.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=800&auto=format&fit=crop', // Computer/online
                'isPublished' => true,
                'createdAt' => now()->subDays(3),
                'updatedAt' => now()->subDays(3),
            ],
            [
                'title' => 'Semarak Perkemahan Pramuka Santri Nusantara di Kaki Gunung',
                'slug' => Str::slug('Semarak Perkemahan Pramuka Santri Nusantara di Kaki Gunung'),
                'excerpt' => 'Kegiatan ekstrakurikuler kepramukaan kembali menggelar Perkemahan Kamis-Jumat (Perkajum) yang melatih kemandirian dan kepemimpinan santri di alam terbuka.',
                'content' => '<p>Bukan sekadar mengaji, santri Al-Hikmah juga ditempa kemandiriannya melalui ekstrakurikuler Pramuka. Pekan ini, ratusan santri kelas 5 KMI mengikuti Perkemahan Kamis-Jumat (Perkajum) yang diadakan di bumi perkemahan kaki gunung terdekat.</p>
                              <p>Kegiatan ini diisi dengan berbagai materi krusial seperti navigasi darat, pertolongan pertama (P3K), hingga *survival skill*. Di malam puncaknya, kegiatan api unggun menjadi momen refleksi dan unjuk kreativitas dari tiap-tiap regu.</p>
                              <p>Pramuka adalah ekstrakurikuler wajib di pondok ini, yang sejalan dengan motto pondok untuk mencetak kader umat yang tidak hanya *tafaqquh fiddin* namun juga kuat fisik dan mentalnya.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?q=80&w=800&auto=format&fit=crop', // Camping/outdoor
                'isPublished' => true,
                'createdAt' => now()->subDays(5),
                'updatedAt' => now()->subDays(5),
            ],
            [
                'title' => 'Ujian Syafahi (Lisan): Tradisi Evaluasi Khas Pondok Modern',
                'slug' => Str::slug('Ujian Syafahi Lisan Tradisi Evaluasi Khas Pondok Modern'),
                'excerpt' => 'Menjelang liburan pertengahan tahun, seluruh santri wajib mengikuti Ujian Syafahi yang menguji mental dan kemampuan Bahasa Arab serta Inggris mereka secara langsung.',
                'content' => '<p>Ujian lisan atau *Imtihan Syafahi* kembali digelar sebagai agenda wajib menjelang liburan pertengahan tahun akademik. Ujian ini menguji sejauh mana santri mampu memahami, menghafal, dan mengaplikasikan pelajaran dalam bahasa Arab dan Inggris secara verbal.</p>
                              <p>Dalam ujian ini, satu santri akan berhadapan dengan tiga orang penguji (asatidz). Selain menguji materi pelajaran seperti *Mahfudzot*, *Muthaala\'ah*, dan *Fiqih*, ujian ini secara khusus dirancang untuk melatih keberanian, mentalitas, dan retorika santri di bawah tekanan.</p>
                              <p>"Santri yang hebat bukan hanya yang bisa menjawab di atas kertas, tapi yang mampu menyuarakan pengetahuannya dengan penuh percaya diri," ungkap Direktur KMI.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1588196749597-9ff0463923b7?q=80&w=800&auto=format&fit=crop', // Classroom/Exam
                'isPublished' => true,
                'createdAt' => now()->subDays(7),
                'updatedAt' => now()->subDays(7),
            ],
            [
                'title' => 'Renovasi Masjid Jami\' Al-Hikmah Hampir Rampung',
                'slug' => Str::slug('Renovasi Masjid Jami Al-Hikmah Hampir Rampung'),
                'excerpt' => 'Pembangunan tahap akhir Masjid Jami\' yang menjadi pusat kegiatan ibadah dan sentral kegiatan santri kini telah mencapai 90 persen.',
                'content' => '<p>Pembangunan perluasan dan renovasi Masjid Jami\' Al-Hikmah yang telah berlangsung sejak tahun lalu kini memasuki tahap akhir (finishing). Hingga berita ini diturunkan, progres pembangunan telah mencapai 90 persen.</p>
                              <p>Masjid yang merupakan "jantung" dari seluruh aktivitas pondok ini diperluas untuk mengakomodasi jumlah santri yang terus bertambah setiap tahunnya. Dengan arsitektur modern yang dipadukan dengan nilai-nilai islami, masjid ini diharapkan dapat menampung hingga 3000 jamaah sekaligus.</p>
                              <p>Pihak yayasan mengucapkan terima kasih yang sebesar-besarnya kepada seluruh wali santri, donatur, dan simpatisan yang telah berkontribusi dalam pembangunan ini.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?q=80&w=800&auto=format&fit=crop', // Mosque architecture
                'isPublished' => true,
                'createdAt' => now()->subDays(10),
                'updatedAt' => now()->subDays(10),
            ],
            [
                'title' => 'Opini: Mengintegrasikan Akhlak Klasik di Era Kecerdasan Buatan',
                'slug' => Str::slug('Opini Mengintegrasikan Akhlak Klasik di Era Kecerdasan Buatan'),
                'excerpt' => 'Di tengah gempuran teknologi AI, pendidikan akhlak khas pesantren menjadi tameng sekaligus kompas bagi generasi muda.',
                'content' => '<p>Era kecerdasan buatan (AI) membawa perubahan masif dalam cara kita belajar, bekerja, dan berinteraksi. Namun, di tengah kemudahan yang ditawarkan algoritma, terjadi degradasi dalam aspek empati dan adab manusia.</p>
                              <p>Pesantren, sebagai benteng terakhir pendidikan moral, memiliki peran yang sangat strategis saat ini. Kitab-kitab klasik seperti *Ta\'lim Muta\'allim* tidak hanya mengajarkan cara memperoleh ilmu, melainkan cara menghargai ilmu dan pemberi ilmu itu sendiri. Sesuatu yang tidak bisa diajarkan oleh mesin pencari manapun.</p>
                              <p>Sudah saatnya santri merangkul teknologi dengan genggaman tangan kanan, sementara tangan kirinya mendekap erat adab dan akhlakul karimah sebagai identitas sejati.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1504164996022-09080787b6b3?q=80&w=800&auto=format&fit=crop', // Technology and hands / abstract
                'isPublished' => true,
                'createdAt' => now()->subDays(14),
                'updatedAt' => now()->subDays(14),
            ],
            [
                'title' => 'Pekan Olahraga dan Seni (Porseni) Al-Hikmah Dimulai',
                'slug' => Str::slug('Pekan Olahraga dan Seni Porseni Al-Hikmah Dimulai'),
                'excerpt' => 'Ajang tahunan bergengsi antar konsulat untuk mengasah minat dan bakat santri di bidang olahraga dan seni resmi dibuka dengan meriah.',
                'content' => '<p>Upacara pembukaan Pekan Olahraga dan Seni (Porseni) tahunan berlangsung sangat meriah di lapangan hijau pondok. Kegiatan ini diawali dengan parade dari masing-masing asrama dan konsulat daerah, menampilkan kekayaan budaya nusantara.</p>
                              <p>Berbagai cabang olahraga dipertandingkan, mulai dari sepak bola, futsal, voli, basket, hingga bulu tangkis. Di bidang seni, terdapat lomba kaligrafi, nasyid, pidato tiga bahasa, hingga teatrikal islami.</p>
                              <p>Porseni bukan sekadar ajang mencari juara, melainkan sarana mempererat *ukhuwah islamiyah* antar santri sekaligus melepaskan penat setelah berbulan-bulan berkutat dengan rutinitas akademik yang padat.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1526676037777-05a232554f77?q=80&w=800&auto=format&fit=crop', // Sports / Running / Stadium
                'isPublished' => true,
                'createdAt' => now()->subDays(20),
                'updatedAt' => now()->subDays(20),
            ]
        ];

        DB::table('News')->insert($news);
    }
}
