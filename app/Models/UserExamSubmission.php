<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExamSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'exam_id', 'submitted_at',
        'listening_score', 'reading_score',
        'writing_score', 'speaking_score', 'total_score', 'status'
    ];

    public $timestamps = false;

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function answers()
    {
        return $this->hasMany(UserAnswer::class, 'submission_id');
    }

    public function writtenResponses()
    {
        return $this->hasMany(UserWrittenResponse::class);
    }

    public function speakingResponses()
    {
        return $this->hasMany(UserSpeakingResponse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}