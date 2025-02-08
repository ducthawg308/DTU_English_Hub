<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ResultExam extends Model
{
    use HasFactory;


    protected $fillable = ['user_id', 'exam_id', 'score', 'total_correct'];
    public $timestamps = false;


    public function user(){
        return $this->belongsTo(User::class);
    }


    public function exam(){
        return $this->belongsTo(Exam::class);
    }
}
