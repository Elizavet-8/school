<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Course;

class CourseController extends Controller
{
    public function getChapters(Course $course)
    {
        return $course->chapters;
    }

    public function getThemes(Chapter $chapter)
    {
        return $chapter->themes;
    }
}