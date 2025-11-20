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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            
            // Mengambil aturan 'onDelete('cascade')' dari migrasi kedua
            $table->foreignId('id_instrument')
                  ->constrained('instruments')
                  ->onDelete('cascade'); // <- Ini adalah aturan final yang Anda inginkan

            $table->text('question_text');
            $table->enum('scoring_type', ['Favorable', 'Unfavorable']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};