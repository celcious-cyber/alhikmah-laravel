<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('beasiswa', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('no_registrasi')->nullable();
            $blueprint->string('jenis_beasiswa'); // Akademik, Non-Akademik, Tahfidz, Tidak Mampu
            $blueprint->string('nama_lengkap');
            $blueprint->string('tempat_lahir')->nullable();
            $blueprint->string('tanggal_lahir')->nullable();
            $blueprint->string('email_pendaftar')->nullable();
            $blueprint->string('telepon')->nullable();
            $blueprint->string('asal_sekolah')->nullable();
            $blueprint->text('prestasi_deskripsi')->nullable();
            $blueprint->string('file_sertifikat')->nullable();
            $blueprint->string('file_sk_hafalan')->nullable();
            $blueprint->string('file_sktm')->nullable();
            $blueprint->string('file_rekomendasi')->nullable();
            $blueprint->string('file_komitmen')->nullable();
            $blueprint->boolean('verified')->default(false);
            $blueprint->timestamp('created_at')->useCurrent();
            $blueprint->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beasiswa');
    }
};
