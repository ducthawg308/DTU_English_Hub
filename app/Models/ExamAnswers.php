<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswers extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'result_exam_id', 'exam_question_id', 'selected_answer', 'is_correct'];
    public $timestamps = false;

    public function examResult(){
        return $this->belongsTo(ResultExam::class);
    }

    public function question(){
        return $this->belongsTo(ExamQuestion::class, 'exam_question_id');
    }
}
