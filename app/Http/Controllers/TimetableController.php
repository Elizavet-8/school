<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimetableController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $course_ids = Course::when($request->grade, function ($query) use ($request) {
                return $query->where('grade', $request->grade);
            })->pluck('id')->toArray();

            return Lesson::whereIn('course_id', $course_ids)->orderBy('started_at')->with('course.user', 'themes')->get();
        }

        $course_ids = Course::when($user->hasRole('student'), function ($query) use ($user) {
            return $query->whereHas('schools', function ($query) use ($user) {
                if ($user->school) {
                    return $query->where('school_id', ($user->school->id));
                }
            })->where('grade', $user->grade);
        })->when($user->hasRole('teacher'), function ($query) use ($user) {
            return $query->orWhere('user_id', $user->id);
        })->when($user->hasRole('individual'), function ($query) use ($user) {
            return $query->orWhereIn('id', $user->availableCourses);
        })->when($request->grade, function ($query) use ($request) {
            return $query->where('grade', $request->grade);
        })->pluck('id')->toArray();

        return Lesson::whereIn('course_id', $course_ids)->orderBy('started_at')->with('course.user', 'themes')->get();
    }
}
