<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['question_id','answer','is_correct'];

    protected function answer(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ucfirst($value)
        );
    }
}
