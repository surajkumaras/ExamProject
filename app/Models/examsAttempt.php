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
}
