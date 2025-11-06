<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_instrument',
        'question_text',
        'scoring_type',
    ];

    public function instrument()
    {
        return $this->belongsTo(Instrument::class, 'id_instrument');
    }
}
