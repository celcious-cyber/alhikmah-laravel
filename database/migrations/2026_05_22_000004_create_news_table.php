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
        Schema::create('News', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('title');
            $blueprint->string('slug')->unique();
            $blueprint->text('excerpt');
            $blueprint->longText('content');
            $blueprint->string('thumbnail')->nullable();
            $blueprint->boolean('isPublished')->default(false);
            $blueprint->timestamp('createdAt')->useCurrent();
            $blueprint->timestamp('updatedAt')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('News');
    }
};
