<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correct extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'to_user_id',
        'practical_id',
        'correct',
        'body',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
