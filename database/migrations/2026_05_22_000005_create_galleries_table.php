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
        Schema::create('Gallery', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('imageUrl');
            $blueprint->string('caption')->nullable();
            $blueprint->string('category')->default('umum');
            $blueprint->integer('order')->default(0);
            $blueprint->timestamp('createdAt')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Gallery');
    }
};
