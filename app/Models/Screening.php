<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    protected $fillable = [
        'user_id', 
        'lokasi', 
        'tanggal_pengisian', 
        'id_recommendation', 
        'status'
    ];

    public function result()
    {
        return $this->hasOne(ScreeningResult::class, 'id_screening');
    }

    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class, 'id_recommendation');
    }
}