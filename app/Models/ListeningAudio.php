<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListeningAudio extends Model
{
    use HasFactory;

    protected $table = 'listening_audios';
    protected $fillable = ['exam_section_id', 'title', 'audio_url'];
    public $timestamps = false;

    public function section()
    {
        return $this->belongsTo(ExamSection::class, 'exam_section_id');
    }
}