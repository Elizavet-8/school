<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'type',
        'test_id',
        'answers',
        'correct',
        'img_url',
        'comment'
    ];
}
