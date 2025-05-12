<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['reading_id', 'question', 'option_a', 'option_b', 'option_c', 'option_d', 'answer'];

    public $timestamps = false;

    public function readings()
    {
        return $this->belongsTo(Reading::class);
    }
}