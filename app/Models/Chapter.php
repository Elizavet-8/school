<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'order',
        'course_id'
    ];

    // public function tests()
    // {
    //     return $this->hasMany(Test::class);
    // }

    // public function files()
    // {
    //     return $this->hasMany(File::class);
    // }

    public function themes()
    {
        return $this->hasMany(Theme::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function percent() {
        $needed = $this->themes->count();

        if ($needed == 0) {
            $needed = 1;
        }

        $current = 0;

        foreach ($this->themes as $theme) {
            if ($theme->percent() >= 50) {
                $current += 1;
            }
        }

        return round(($current/$needed)*100);
    }

    // public function complete()
    // {
    //     return false;
    //     $completedTests = 0;
    //     $tests = $this->tests()->count();
    //     foreach ($this->tests as $test) {
    //         if ($test->passed()) {
    //             $completedTests++;
    //         }
    //     }
    //     return $completedTests == $tests;
    // }

    public function complete_count(int $id)
    {
        $themes = $this->themes;

        $count = 0;

        foreach ($themes as $theme) {
            if ($theme->complete($id)) {
                $count++;
            }
        }

        return $count;
    }

    public function complete(int $id)
    {
        $themes = $this->themes;

        $needed = count($themes);
        $actual = 0;

        foreach ($themes as $theme) {
            if ($theme->complete($id)) {
                $actual++;
            }
        }

        return $needed == $actual;
    }

    public function available() : bool
    {
        return true;
        if ($this->order == 1) {
            return true;
        }

        $previous = $this->course->chapters->where('order', $this->order - 1)->first();

        if ($previous) {
            return $previous->complete();
        }

        return true;
    }


}
