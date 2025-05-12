<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSpeakingResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id', 'speaking_prompt_id', 'audio_url', 'transcript', 'ai_score', 'ai_feedback'
    ];

    public $timestamps = false;

    public function submission()
    {
        return $this->belongsTo(UserExamSubmission::class);
    }

    public function prompt()
    {
        return $this->belongsTo(SpeakingPrompt::class, 'speaking_prompt_id');
    }
}
