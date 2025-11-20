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
        Schema::create('screenings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        // KOLOM WAJIB AGAR BISA DISIMPAN
        $table->string('lokasi')->nullable(); 
        $table->date('tanggal_pengisian')->nullable();
        
        // Relasi ke rekomendasi (hasil rule)
        $table->foreignId('id_recommendation')
              ->nullable()
              ->constrained('recommendations')
              ->onDelete('set null');

        $table->string('status')->default('draft'); // draft/completed
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screenings');
    }
};
