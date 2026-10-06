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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Data Demografi & Pembayaran
            $table->string('name');
            $table->string('email');
            $table->string('no_hp')->unique(); // Dibuat unik agar tidak ada nomor ganda
            $table->string('jenis_ewallet');

            // Data Hasil Skrining (Boleh kosong di awal saat register)
            $table->date('tanggal')->nullable();
            $table->string('id_sesi')->nullable();
            $table->integer('skor')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
