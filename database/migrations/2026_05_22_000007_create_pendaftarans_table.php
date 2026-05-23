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
        Schema::create('pendaftaran', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('no_registrasi')->nullable();
            $blueprint->string('email_pendaftar')->nullable();
            $blueprint->string('nama_lengkap');
            $blueprint->string('tempat_lahir')->nullable();
            $blueprint->string('tanggal_lahir')->nullable();
            $blueprint->string('jenis_kelamin')->nullable();
            $blueprint->string('nisn')->nullable();
            $blueprint->string('nik')->nullable();
            $blueprint->string('agama')->nullable();
            $blueprint->string('hobi')->nullable();
            $blueprint->string('cita_cita')->nullable();
            $blueprint->string('anak_ke')->nullable();
            $blueprint->string('jumlah_saudara_kandung')->nullable();
            $blueprint->text('alamat')->nullable();
            $blueprint->string('rt_rw')->nullable();
            $blueprint->string('dusun')->nullable();
            $blueprint->string('desa')->nullable();
            $blueprint->string('kecamatan')->nullable();
            $blueprint->string('kabupaten')->nullable();
            $blueprint->string('provinsi')->nullable();
            $blueprint->string('kode_pos')->nullable();
            $blueprint->string('no_kk')->nullable();
            $blueprint->string('kepala_keluarga')->nullable();
            $blueprint->string('nama_ayah_kandung')->nullable();
            $blueprint->string('status_ayah')->nullable();
            $blueprint->text('alamat_ayah')->nullable();
            $blueprint->string('nik_ayah')->nullable();
            $blueprint->string('pekerjaan_ayah')->nullable();
            $blueprint->string('nama_ibu_kandung')->nullable();
            $blueprint->string('status_ibu')->nullable();
            $blueprint->string('nik_ibu')->nullable();
            $blueprint->string('pekerjaan_ibu')->nullable();
            $blueprint->text('alamat_ibu')->nullable();
            $blueprint->string('nama_wali')->nullable();
            $blueprint->string('nik_wali')->nullable();
            $blueprint->text('alamat_wali')->nullable();
            $blueprint->string('penghasilan')->nullable();
            $blueprint->string('no_kks')->nullable();
            $blueprint->string('no_pkh')->nullable();
            $blueprint->string('no_kip')->nullable();
            $blueprint->string('asal_sekolah')->nullable();
            $blueprint->string('npsn_sekolah')->nullable();
            $blueprint->text('alamat_sekolah')->nullable();
            $blueprint->string('no_surat_lulus')->nullable();
            $blueprint->string('no_blangko_ijazah')->nullable();
            $blueprint->string('nilai_rata2_ijazah')->nullable();
            $blueprint->string('foto_3x4')->nullable();
            $blueprint->string('file_ijazah')->nullable();
            $blueprint->string('file_surat_lulus')->nullable();
            $blueprint->string('file_akte_lahir')->nullable();
            $blueprint->string('file_kk')->nullable();
            $blueprint->string('file_kartu_nisn')->nullable();
            $blueprint->string('file_kartu_kip')->nullable();
            $blueprint->string('file_kartu_pkh')->nullable();
            $blueprint->string('file_kartu_kks')->nullable();
            $blueprint->string('file_foto_rapot')->nullable();
            $blueprint->boolean('verified')->default(false);
            $blueprint->string('verified_by')->nullable();
            $blueprint->timestamp('created_at')->useCurrent();
            $blueprint->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
