<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    protected $guarded = [];
    
    protected $fillable = [
        'user_id', 
        'lokasi', 
        'tanggal_pengisian', 
        // id_recommendation sudah dihapus dari sini
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function result()
    {
        return $this->hasOne(ScreeningResult::class, 'id_screening');
    }
    
    // Fungsi recommendation() sudah dihapus dari sini
    
    public function responses()
    {
        return $this->hasMany(ScreeningResponse::class, 'id_screening');
    }
}