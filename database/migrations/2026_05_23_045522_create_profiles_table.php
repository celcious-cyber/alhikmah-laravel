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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('pondok'); // Tipe profil
            $table->string('name'); // Nama lembaga
            $table->string('tagline')->nullable(); // Slogan singkat
            $table->text('description')->nullable(); // Deskripsi umum
            $table->text('history')->nullable(); // Sejarah lembaga
            $table->string('head_name')->nullable(); // Nama kepala lembaga
            $table->string('head_title')->nullable(); // Jabatan/gelar kepala
            $table->string('thumbnail')->nullable(); // Foto utama / banner
            $table->string('head_photo')->nullable(); // Foto kepala lembaga
            $table->json('background_image')->nullable(); // Foto carousel
            // Legalitas & Akreditasi
            $table->string('npsn')->nullable(); // NPSN
            $table->string('nss')->nullable(); // NSS
            $table->string('accreditation')->nullable(); // Akreditasi (A/B/C)
            $table->string('accreditation_year')->nullable();
            $table->string('operational_permit')->nullable(); // No SK Operasional
            $table->string('permit_date')->nullable(); // Tanggal SK
            $table->string('permit_issuer')->nullable(); // Penerbit SK
            // Kurikulum & Fitur (disimpan sebagai JSON)
            $table->json('features')->nullable(); // Fitur/unggulan
            $table->json('subjects')->nullable(); // Mata pelajaran
            $table->json('achievements')->nullable(); // Prestasi
            $table->json('gallery')->nullable(); // Foto-foto tambahan
            $table->integer('total_students')->nullable();
            $table->integer('total_teachers')->nullable();
            $table->integer('year_established')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
