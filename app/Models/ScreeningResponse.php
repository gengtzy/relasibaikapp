<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScreeningResponse extends Model
{
    protected $fillable = [
        'id_screening',
        'id_question',
        'answer_value',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'id_question');
    }
}
