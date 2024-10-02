<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class examsAttempt extends Model
{
    use HasFactory;

    public $fillable = [
        'exam_id',
        'user_id',
    ];

    public function exam()
    {
        return $this->hasOne(Exam::class, 'id', 'exam_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function examAnswer()
    {
        return $this->belongsTo(examsAnswer::class);
    }
}
