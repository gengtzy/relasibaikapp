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
        Schema::create('screening_responses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_screening')->constrained('screenings')->onDelete('cascade');
        $table->foreignId('id_question')->constrained('questions')->onDelete('cascade');
        $table->integer('answer_value'); 
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screening_responses');
    }
};
