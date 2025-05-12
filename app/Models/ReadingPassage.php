<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingPassage extends Model
{
    use HasFactory;

    protected $fillable = ['exam_section_id', 'title', 'content'];

    public $timestamps = false;

    public function section()
    {
        return $this->belongsTo(ExamSection::class, 'exam_section_id');
    }
}