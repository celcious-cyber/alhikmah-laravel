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
        $columnsToDrop = ['npsn', 'nss', 'accreditation', 'accreditation_year', 'operational_permit', 'permit_date', 'permit_issuer'];

        Schema::table('curricula', function (Blueprint $table) use ($columnsToDrop) {
            $table->dropColumn($columnsToDrop);
            $table->json('legalities')->nullable()->after('head_photo');
        });

        Schema::table('profiles', function (Blueprint $table) use ($columnsToDrop) {
            $table->dropColumn($columnsToDrop);
            $table->json('legalities')->nullable()->after('head_photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $columnsToAdd = function (Blueprint $table) {
            $table->string('npsn')->nullable();
            $table->string('nss')->nullable();
            $table->string('accreditation')->nullable();
            $table->string('accreditation_year')->nullable();
            $table->string('operational_permit')->nullable();
            $table->string('permit_date')->nullable();
            $table->string('permit_issuer')->nullable();
        };

        Schema::table('curricula', function (Blueprint $table) use ($columnsToAdd) {
            $columnsToAdd($table);
            $table->dropColumn('legalities');
        });

        Schema::table('profiles', function (Blueprint $table) use ($columnsToAdd) {
            $columnsToAdd($table);
            $table->dropColumn('legalities');
        });
    }
};
