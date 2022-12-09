<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lessons = Lesson::orderBy('started_at')->with('course.user', 'themes')->get();

        return $lessons;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'course_id' => 'exists:App\Models\Course,id',
            'started_at' => 'required|before:ended_at',
            'ended_at' => 'required',
        ],
            [
                'exists' => 'Курс не найден, возможно он был удален',
                'required' => 'Все обязательные поля должны быть заполнены',
                'before' => 'Время начала должно быть до времени окончания'
            ]);

        $lesson = new Lesson();
        $lesson->course_id = $request->course_id;
        $lesson->started_at = Carbon::parse($request->started_at);
        $lesson->ended_at = Carbon::parse($request->ended_at);
        
        $this->checkInterruptedLessons($lesson);

        $lesson->save();

        foreach ($request->themes as $theme) {
            $lesson->themes()->attach($theme);
        }

        return $lesson;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {
        $validator = $request->validate([
            'course_id' => 'exists:App\Models\Course,id',
            'started_at' => 'required|before:ended_at',
            'ended_at' => 'required',
        ],
            [
                'exists' => 'Курс не найден, возможно он был удален',
                'required' => 'Все обязательные поля должны быть заполнены',
                'before' => 'Время начала должно быть до времени окончания'
            ]);
            
        $lesson->course_id = $request->course_id;
        $lesson->started_at = Carbon::parse($request->started_at);
        $lesson->ended_at = Carbon::parse($request->ended_at);
        $lesson->save();

        $lesson->themes()->detach();
        foreach ($request->themes as $theme) {
            $lesson->themes()->attach($theme);
        }

        return $lesson;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function checkInterruptedLessons(Lesson $lesson)
    {
        $course = $lesson->course;
        $user = $course->user;
        $course_ids = Course::where('user_id', $user->id)->pluck('id')->toArray();

        $interrupted_my_lessons = $this->getInterruptedLessons($lesson, $course_ids);

        if ($interrupted_my_lessons->count() > 0) {
            $interrupted_my_lesson = $interrupted_my_lessons->first();
            

            $error = ValidationException::withMessages([
                'started_at' => ['Время урока совпадает с другим Вашим уроком (курс "' . $interrupted_my_lesson->course->title . '")']
            ]);
            throw $error;
        }

        $course_ids = Course::where('grade', $course->grade)->pluck('id')->toArray();

        $interrupted_other_lessons = $this->getInterruptedLessons($lesson, $course_ids);

        if ($interrupted_other_lessons->count() > 0) {
            $interrupted_other_lesson = $interrupted_other_lessons->first();

            $error = ValidationException::withMessages([
                'started_at' => ['Время урока совпадает с другим уроком (курс "' . $interrupted_other_lesson->course->title . '" учитель ' . $interrupted_other_lesson->course->user->name . ')']
            ]);
            throw $error;
        }
    }

    private function getInterruptedLessons(Lesson $lesson, $course_ids)
    {
        $lessons_this_time = Lesson::whereBetween('started_at', [$lesson->started_at, $lesson->ended_at])
            ->orWhereBetween('ended_at', [$lesson->started_at, $lesson->ended_at])
            ->orWhere('started_at', '<=', $lesson->started_at)
            ->where('ended_at', '>=', $lesson->ended_at)
            ->get();
        
        return $lessons_this_time->whereIn('course_id', $course_ids);
    }
}
