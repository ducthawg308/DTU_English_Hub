<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Exam extends Model
{
    use HasFactory;


    protected $fillable = ['name', 'level_id'];
    public $timestamps = false;




    //  Exam có nhiều ExamQuestion
    public function examQuestions()
    {
        return $this->hasMany(ExamQuestion::class);
    }


    //  Exam có nhiều Result Exam
    public function resultExams(){
        return $this->hasMany(ResultExam::class);
    }


    public function level(){
        return $this->belongsTo(Level::class);
    }
}
