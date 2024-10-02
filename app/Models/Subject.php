<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
