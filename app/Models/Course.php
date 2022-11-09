<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Kyslik\ColumnSortable\Sortable;

class Course extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'title',
        'description',
        'img_url',
        'hours',
        'user_id',
        'grade'
    ];

    protected $sortable = [
        'title',
        'user_id',
        'grade'
    ];

    protected $appends = [
      "not_read_course_comments"
    ];

    public function percent() {
        $needed = $this->chapters->count();

        if ($needed == 0) {
            $needed = 1;
        }

        $current = 0;

        foreach ($this->chapters as $chapter) {
            if ($chapter->percent() >= 50) {
                $current += 1;
            }
        }

        return round(($current/$needed)*100);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class)->with('themes');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function students()
    {
        return User::where('grade', $this->grade)->whereIn('school_id', $this->schools->pluck('id'))->get();
    }

    public function studentsIds()
    {
        return User::where('grade', $this->grade)->whereIn('school_id', $this->schools->pluck('id'))->pluck('id');
    }

    public function schools()
    {
        return $this->belongsToMany(School::class);
    }

    public function curricula()
    {
        return $this->belongsToMany(Curriculum::class);
    }

    public function completePercent($id)
    {
        $themes = $this->themes();

        $needed = count($themes);
        $actual = 0;

        foreach ($themes as $theme) {
            if ($theme->complete($id)) {
                $actual++;
            }
        }

        if ($needed == 0) {
            return 0;
        }

        return round(($actual/$needed)*100);
        // $user = $this->users()->find($id);
        // $chaptersCount = $this->chapters()->count();

        // if (!$user) {
        //     return 0;
        // }

        // $completed = $this->users()->find($id)->pivot->completed;
        // return round(($completed/$chaptersCount)*100);
        /*$completedChapters = 0;
        $chaptersCount = $this->chapters()->count();
        foreach ($this->chapters as $chapter) {
            if ($chapter->complete()) {
                $completedChapters++;
            }
        }
        return round(($completedChapters/$chaptersCount)*100);*/
    }

    public function completeCount($id)
    {
        $themes = $this->themes();

        $count = 0;

        foreach ($themes as $theme) {
            if ($theme->complete($id)) {
                $count++;
            }
        }

        return $count;
        // $user = $this->users()->find($id);

        // if (!$user) {
        //     return 0;
        // }

        // $completed = $this->users()->find($id)->pivot->completed;
        // return $completed;
        /*$completedChapters = 0;
        foreach ($this->chapters as $chapter) {
            if ($chapter->complete()) {
                $completedChapters++;
            }
        }
        return $completedChapters;*/
    }

    public function completeCheck()
    {
        $completedChapters = 0;
        foreach ($this->chapters as $chapter) {
            if ($chapter->complete()) {
                $completedChapters++;
            }
        }
        return $completedChapters;
    }

    public function countThemes() {
        $chapters = $this->chapters;
        $sum = 0;

        foreach ($chapters as $key => $chapter) {
            $sum += $chapter->themes->count();
        }

        return $sum;
    }

    public function themes() {
        $chapters = $this->chapters;
        $themes = [];

        foreach ($chapters as $key => $chapter) {
            array_push($themes, ...$chapter->themes);
        }

        return $themes;
    }

    public function getNotReadCourseCommentsAttribute(){

        if (empty($this->themes()))
            return 0;
        $tmp = 0;
        foreach ($this->themes() as $theme)
            $tmp += $theme->not_read_comments;

        return $tmp;
    }
}
