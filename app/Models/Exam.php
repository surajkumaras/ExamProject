<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_name',
        'subject_id',
        'date',
        'time',
        'created_at',
        'updated_at',
        'attempt',
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class,'id','subject_id');
    }
}
