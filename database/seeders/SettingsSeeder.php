<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'about_title', 'value' => 'Tentang Kami', 'group' => 'about'],
            ['key' => 'about_subtitle', 'value' => 'Mengenal Lebih Dekat Al-Hikmah', 'group' => 'about'],
            ['key' => 'about_p1', 'value' => 'Pondok Pesantren Modern Al-Hikmah didirikan dengan visi untuk mencetak generasi yang tidak hanya unggul dalam ilmu agama, tetapi juga kompeten dalam ilmu pengetahuan umum.', 'group' => 'about'],
            ['key' => 'about_p2', 'value' => 'Berlokasi di lingkungan yang asri, kami menyediakan fasilitas pendidikan terlengkap untuk menunjang tumbuh kembang santri.', 'group' => 'about'],
            ['key' => 'founder_name', 'value' => 'KH. Syihabuddin Muhammad', 'group' => 'about'],
            ['key' => 'founder_title', 'value' => 'Pimpinan Pondok', 'group' => 'about'],
            ['key' => 'about_image', 'value' => 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Pimpinan', 'group' => 'about'],
            ['key' => 'quote_text', 'value' => 'Dia (Allah) menganugerahkan HIKMAH kepada siapa yang Dia kehendaki...', 'group' => 'about'],
            ['key' => 'quote_source', 'value' => '(Q.S. Al-Baqarah : 269)', 'group' => 'about']
        ];

        foreach ($settings as $setting) {
            DB::table('Settings')->updateOrInsert(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'group' => $setting['group'],
                    'updatedAt' => now(),
                ]
            );
        }
    }
}
