<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function purchasedExercises(){
        // Một User có thể có nhiều PurchasedExercise
        return $this->hasMany(PurchasedExercise::class);
    }

    public function topicVocabulary(){
        // Một User có thể có nhiều TopicVocabulary
        return $this->hasMany(TopicVocabulary::class);
    }

    public function userExamSubmissions(){
        return $this->hasMany(UserExamSubmission::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
    
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function likes()
    {
        return $this->hasMany(BlogLike::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function userVocabularyBox()
    {
        return $this->hasMany(UserVocabularyBox::class);
    }
}
