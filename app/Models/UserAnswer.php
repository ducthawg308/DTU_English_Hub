<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id', 'question_id', 'selected_choice_label', 'is_correct', 'score_awarded'
    ];

    public $timestamps = false;

    public function submission()
    {
        return $this->belongsTo(UserExamSubmission::class, 'submission_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}