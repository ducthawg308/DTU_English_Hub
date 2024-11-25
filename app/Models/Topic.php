<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $fillable = ['level_id', 'name', 'total_less', 'desc'];

    public $timestamps = false;

    public function listeningExercises()
    {
        return $this->hasMany(ListeningExercise::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
