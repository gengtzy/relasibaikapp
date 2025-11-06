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
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['id_instrument']);

            $table->foreign('id_instrument')
                  ->references('id')
                  ->on('instruments')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['id_instrument']);

            $table->foreign('id_instrument')
                  ->references('id')
                  ->on('instruments')
                  ->onDelete('restrict');
        });
    }
};
