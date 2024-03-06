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
        Schema::create('informasi', function (Blueprint $table) {
            $table->id();
            $table->string('cover')->nullable();
            $table->string('title');
            $table->bigInteger('kategori_id');
            $table->enum('status_informasi',['informasi','berita'])->default('informasi');
            $table->enum('status',['publis','pending','ditolak'])->default('pending');
            $table->bigInteger('user_id');
            $table->binary('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi');
    }
};
