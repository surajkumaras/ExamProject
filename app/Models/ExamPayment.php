<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamPayment extends Model
{
    use HasFactory;

    protected $fillable = ['exam_id','user_id','payment_details'];
}
