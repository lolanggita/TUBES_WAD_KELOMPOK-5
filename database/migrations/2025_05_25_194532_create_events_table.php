<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // Judul kegiatan
            $table->string('title');

            // Deskripsi (boleh kosong)
            $table->text('description')->nullable();

            // Waktu mulai (harus di‐isi)
            $table->dateTime('start_time');

            // Waktu selesai (opsional)
            $table->dateTime('end_time')->nullable();

            // Apakah event ini bisa diregistrasi oleh mahasiswa
            $table->boolean('is_registrable')->default(false);

            // ID user yang membuat event (administrator atau ukm)
            $table->unsignedBigInteger('created_by');

            $table->timestamps();

            // Foreign key ke tabel users
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
