<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'test_id',
        'finished_at',
        'correct',
        'questions',
        'is_passed',
        'answers',
        'is_finished'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function testWithQuestions()
    {
        return $this->belongsTo(Test::class, 'test_id')->with('questions');
    }
}
