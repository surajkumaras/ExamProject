<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Subject extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->hasMany(Category::class);
    }

    public function question()
    {
        return $this->hasMany(Question::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtoupper($value)
        );
    }
}
