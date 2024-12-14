<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    use HasFactory;
    protected $table = 'vocabularys';
    public $timestamps = false;
    protected $fillable = [
        'user_id', 
        'word', 
        'pronounce', 
        'meaning',
        'example',
        'topic_id',
        'type_id',
        'image',
        'create_at',
    ];
    public function topicVocabulary()
    {
        return $this->belongsTo(TopicVocabulary::class, 'topic_id', 'id');
    }

    public function typeVocabulary()
    {
        return $this->belongsTo(TypeVocabulary::class, 'type_id', 'id');
    }

    public function wordnote(){
        // Một Vocab có thể có nhiều Wordnote
        return $this->hasMany(Wordnote::class);
    }
}
