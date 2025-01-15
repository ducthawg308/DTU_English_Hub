<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ExamQuestion extends Model
{
    use HasFactory;


    protected $fillable = ['exam_id', 'question', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer'];
    public $timestamps = false;


    public function exam(){
        return $this->belongsTo(Exam::class);
    }
}
