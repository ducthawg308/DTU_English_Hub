<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeVocabulary extends Model{
    use HasFactory;
    protected $table = 'type_vocabularys';
    protected $fillable = ['name'];

    public function vocabulary(){
        return $this->hasMany(Vocabulary::class, 'type_id', 'id');
    }

}
