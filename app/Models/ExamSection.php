<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'skill',
        'instruction',
        'total_score',
        'time_limit_minutes',
    ];

    public $timestamps = false;

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function listeningAudios()
    {
        return $this->hasMany(ListeningAudio::class);
    }

    public function readingPassages()
    {
        return $this->hasMany(ReadingPassage::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function writingPrompts()
    {
        return $this->hasMany(WritingPrompt::class);
    }

    public function speakingPrompts()
    {
        return $this->hasMany(SpeakingPrompt::class);
    }
}