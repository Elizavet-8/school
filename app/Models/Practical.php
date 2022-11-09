<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Practical extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'theme_id',
        'section_id',
        'title',
        'purpose',
        'task',
        'file',
        'link',
        'image',
        'recommendations',
        'criteria',
        'howtosend',

        'correct',
        'correct_file',
        'to_user_id'
    ];
    protected $appends = ["not_read_comments"];
    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    public function feedbacks()
    {
        return $this->morphMany(Feedback::class, 'feedbacktable');
    }

    public function corrects()
    {
        return $this->morphMany(Correct::class, 'correcttable');
    }

    public function getNotReadCommentsAttribute(){

        if (is_null($this->comments()))
            return 0;

        return $this->comments()->whereNull("read_at")->get()->count();
    }
}
