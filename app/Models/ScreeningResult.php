<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScreeningResult extends Model
{
    protected $fillable = [
        'id_screening',
        'id_recommendation', // <-- Baru dipindah ke sini
        'fpq_score',   
        'mciq_score',  
        'fmwb_score',  
        'total_score',
        'fpq_category', 
        'mciq_category', 
        'fmwb_category', 
    ];

    // Relasi balik ke tabel induk (Screening)
    public function screening()
    {
        return $this->belongsTo(Screening::class, 'id_screening');
    }

    // Pindahan relasi dari model Screening
    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class, 'id_recommendation');
    }
}