<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model{
    use HasFactory;

    protected $fillable = [
        'level_id', 
        'name', 
        'total_less', 
        'desc',
        'price'
    ];

    public $timestamps = false;
    public function listeningExercises()
    {
        return $this->hasMany(ListeningExercise::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function purchasedExercises()
    {
        return $this->hasMany(PurchasedExercise::class, 'topic_id'); 
    }
}

