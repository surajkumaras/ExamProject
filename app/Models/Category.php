<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['subject_id','name','status'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
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
