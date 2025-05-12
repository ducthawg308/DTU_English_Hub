<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'level'];

    public $timestamps = false;

    public function readingQuestions()
    {
        return $this->hasMany(ReadingQuestion::class);
    }
}