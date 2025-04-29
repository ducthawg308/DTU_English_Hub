<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVocabularyBox extends Model
{
    protected $table = 'user_vocabulary_boxes';

    protected $fillable = [
        'user_id',
        'vocabulary_id',
        'box_type',
        'next_review_at',
        'last_review_at',
        'review_count',
    ];

    public $timestamps = true;

    public function vocabulary()
    {
        return $this->belongsTo(Vocabulary::class, 'vocabulary_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
