<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasedExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'user_id', 
        'topic_id',
        'price', 
        'order_info', 
        'purchase_date', 
        'status'
    ];
    
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }
}
