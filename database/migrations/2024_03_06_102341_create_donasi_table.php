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
        Schema::create('donasi', function (Blueprint $table) {
            $table->id();
            $table->string('cover')->nullable();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->bigInteger('kategori_id');
            $table->enum('status',['publis','pending','ditolak'])->default('pending');
            $table->enum('status_donasi',['berjalan','selesai'])->default('berjalan');
            $table->bigInteger('user_id');
            $table->decimal('total_dana',12,8);
            $table->decimal('total_donatur',12,8);
            $table->binary('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasi');
    }
};
