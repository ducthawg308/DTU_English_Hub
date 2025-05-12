<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exams';

    protected $fillable = [
        'title',
        'level',
        'desc',
    ];

    public $timestamps = false;

    // Một đề thi có nhiều phần (listening, reading, ...)
    public function sections()
    {
        return $this->hasMany(ExamSection::class);
    }

    // Lấy các section theo kỹ năng cụ thể
    public function listeningSection()
    {
        return $this->hasOne(ExamSection::class)->where('skill', 'listening');
    }

    public function readingSection()
    {
        return $this->hasOne(ExamSection::class)->where('skill', 'reading');
    }

    public function writingSection()
    {
        return $this->hasOne(ExamSection::class)->where('skill', 'writing');
    }

    public function speakingSection()
    {
        return $this->hasOne(ExamSection::class)->where('skill', 'speaking');
    }
}
