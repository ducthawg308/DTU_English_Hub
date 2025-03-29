<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';
    protected $fillable = ['user_id', 'title', 'subject', 'description', 'file_path', 'file_type', 'downloads', 'views'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}