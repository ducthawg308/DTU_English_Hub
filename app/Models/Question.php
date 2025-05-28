<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_section_id',
        'passage_id',
        'audio_id',
        'question_text',
        'question_type',
        'correct_choice_label',
        'score'
    ];

    public $timestamps = false;

    public function examSection()
    {
        return $this->belongsTo(ExamSection::class, 'exam_section_id');
    }

    public function passage()
    {
        return $this->belongsTo(ReadingPassage::class, 'passage_id');
    }

    public function audio()
    {
        return $this->belongsTo(ListeningAudio::class, 'audio_id');
    }

    public function choices()
    {
        return $this->hasMany(QuestionChoice::class, 'question_id');
    }
}