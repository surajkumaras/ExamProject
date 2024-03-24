<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class examsAnswer extends Model
{
    use HasFactory;

    public $fillable = [
        'attempt_id',
        'question_id',
        'answer_id',
    ];

    public function question()
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }

    public function answers()
    {
        return $this->hasOne(Answer::class, 'id', 'answer_id');
    }

    public function examsAttempt()
    {
        return $this->belongsTo(examsAttempt::class);
    }
}
