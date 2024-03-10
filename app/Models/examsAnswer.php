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
}
