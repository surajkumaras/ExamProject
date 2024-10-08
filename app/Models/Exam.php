<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\examsAttempt;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'enterance_id',
        'plan',
        'price',
        'marks'
    ];

    protected $appends = ['attempt_counter'];
    public $count = 0;

    public function subjects()
    {
        return $this->hasMany(Subject::class,'id','subject_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id','id');
    }

    public function getQnaExam()
    {
        return $this->hasMany(QnaExam::class,'exam_id','id');
    }

    public function getAttemptCounterAttribute()
    {
        return $this->count;
    }

    public function getIdAttribute($value)
    {
        $attemptCount = examsAttempt::where(['exam_id'=>$value,'user_id'=>auth()->user()->id])->count();
        $this->count = $attemptCount;
        return $value;
    }

    public function getQnaExamAttribute()
    {
        return $this->hasMany(QnaExam::class,'exam_id','id');
    }

    protected function exam_name(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ucfirst($value)
        );
    }
}
