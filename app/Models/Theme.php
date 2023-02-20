<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Kyslik\ColumnSortable\Sortable;
use Ramsey\Uuid\Type\Integer;

class Theme extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'title',
        'order',
        'chapter_id'
    ];

    protected $appends = ["not_read_comments"];
    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function files()
    {
        return $this->hasMany(File::class)->where('url', '!=', "");
    }

    public function filesAdmin()
    {
        return $this->hasMany(File::class);
    }

    public function percent()
    {
        $needed = 3;
        $current = 0;

        if ($this->files->whereIn('type', ["video"])->count() > 0) {
            $current += 1;
        }

        if ($this->files->count() > 0) {
            $current += 1;
        }

        if ($this->tests->count() > 0) {
            $current += 1;
        }

        if ($this->practicals->count() > 0) {
            $current += 1;
        }

        return round(($current / $needed) * 100);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function is_available()
    {
        return $this->tests->count() > 0 || $this->files->count() > 0;
    }

    public function is_videos(int $id)
    {
        return $this->files->where('section_id', $id)->whereIn('type', ["video"])->count() > 0;
    }

    public function getVideosCountAttribute()
    {
        return $this->files->whereIn('type', ["video"])->count();
    }

    public function is_presentations(int $id)
    {
        return $this->files->where('section_id', $id)->whereIn('type', ["ppt", "pptx"])->count() > 0;
    }

    public function getPresentationsCountAttribute()
    {
        return $this->files->whereIn('type', ["ppt", "pptx"])->count();
    }

    public function is_tests(int $id)
    {
        return $this->tests->where('section_id', $id)->count() > 0;
    }

    public function getTestsCountAttribute()
    {
        return $this->tests->count();
    }

    public function complete(int $id)
    {
        $tests = Test::where("theme_id", $this->id)->where("is_required", true)->with('attempts')->get();

        if (count($tests) == 0) {
            return false;
        }

        $needed = count($tests);
        $actual = 0;

        foreach ($tests as $test) {
            if ($test->attempts()->where('user_id', $id)->where('is_passed', true)->count() > 0) {
                $actual++;
            }
        }

        return $needed == $actual;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    public function practicals()
    {
        return $this->hasMany(Practical::class);
    }

    public function is_practicals(int $id)
    {
        return $this->practicals->where('section_id', $id)->count() > 0;
    }

    public function getPracticalsCountAttribute()
    {
        return $this->practicals->count();
    }


//    public function is_practicals(int $id)
//    {
//        return $this->files->where('section_id', $id)->whereIn('type', ["practical"])->count() > 0;
//    }

    //protected $with = ["comments"];

    public function getNotReadCommentsAttribute(){

        if (is_null($this->comments()))
            return 0;

        return $this->comments()->whereNull("read_at")->get()->count();
    }
}
