<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wordnote extends Model
{
    use HasFactory;
    protected $table = 'wordnotes';
    protected $fillable = ['user_id', 'vocabulary_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vocabulary(){
        return $this->belongsTo(Vocabulary::class);
    }
}
