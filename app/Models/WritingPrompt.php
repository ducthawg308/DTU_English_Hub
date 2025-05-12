<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WritingPrompt extends Model
{
    use HasFactory;

    protected $fillable = ['exam_section_id', 'prompt_text'];

    public $timestamps = false;

    public function section()
    {
        return $this->belongsTo(ExamSection::class);
    }
}