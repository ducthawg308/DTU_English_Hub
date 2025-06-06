<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeTopic extends Model
{
    use HasFactory;

    protected $table = 'type_topics';

    protected $fillable = [
        'name',
    ];

    public function topicVocabularys()
    {
        return $this->hasMany(TopicVocabulary::class, 'type_id');
    }
}
