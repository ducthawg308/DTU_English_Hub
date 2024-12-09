<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicVocabulary extends Model
{
    use HasFactory;
    protected $table = 'topic_vocabularys';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
    ];

    public function vocabulary()
    {
        return $this->hasMany(Vocabulary::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
