<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audios extends Model
{
    use HasFactory;

    protected $fillable = ['listening_id', 'audio', 'answer_correct'];
    public $timestamps = false;

    public function listeningExercise()
    {
        return $this->belongsTo(ListeningExercise::class, 'listening_id');
    }
}


