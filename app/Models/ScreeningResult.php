<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScreeningResult extends Model
{
    protected $fillable = [
        'id_screening',
        'fpq_score',   // Skor Ayah
        'mciq_score',  // Skor Ibu
        'fmwb_score',  // Skor Keluarga Lain
        'total_score', // Skor Total
    ];
}
