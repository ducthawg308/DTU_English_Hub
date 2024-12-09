<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListeningExercise extends Model
{
    use HasFactory;

    // Tên bảng (nếu không cần, có thể bỏ dòng này)
    protected $table = 'listening_exercises';

    // Các cột được phép gán giá trị hàng loạt
    protected $fillable = ['topic_id', 'title'];

    // Tắt timestamps nếu bảng không có created_at và updated_at
    public $timestamps = false;

    public function audios()
    {
        return $this->hasMany(Audios::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
