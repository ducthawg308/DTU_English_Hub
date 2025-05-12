<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWrittenResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id', 'writing_prompt_id', 'response_text', 'ai_score', 'ai_feedback'
    ];

    public $timestamps = false;

    public function submission()
    {
        return $this->belongsTo(UserExamSubmission::class);
    }

    public function prompt()
    {
        return $this->belongsTo(WritingPrompt::class, 'writing_prompt_id');
    }
}