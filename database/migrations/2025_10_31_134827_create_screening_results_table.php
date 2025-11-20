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
        Schema::create('screening_results', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_screening')->constrained('screenings')->onDelete('cascade');
        
        // KOLOM SKOR & KATEGORI (Wajib ada)
        $table->integer('fpq_score')->default(0);
        $table->string('fpq_category')->nullable(); // T/S/R

        $table->integer('mciq_score')->default(0);
        $table->string('mciq_category')->nullable();

        $table->integer('fmwb_score')->default(0);
        $table->string('fmwb_category')->nullable();

        $table->integer('total_score')->default(0);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screening_results');
    }
};
