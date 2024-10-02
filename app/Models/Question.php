<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['question','explaination'];

    public function answers()
    {
        return $this->hasMany(Answer::class,'question_id','id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id','id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    protected function question(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ucfirst($value)
        );
    }

  
}
