<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Comment extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'teacher_id',
        'theme_id',
        'practical_id',
        'parent_id',
        'body',
        'image',
        'file',
        'read_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }


    public function getDateAsCorbonAttribute()
    {
        return Carbon::parse($this->created_at);
    }
}
