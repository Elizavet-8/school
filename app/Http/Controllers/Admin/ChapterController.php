<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function createOfCourse(Course $course)
    {
        return view('admin.chapter.create', [
            'course' => $course,
        ]);
    }

    public function tests(Chapter $chapter)
    {
        return view('admin.chapter.tests', [
            'chapter' => $chapter
        ]);
    }

    public function files(Chapter $chapter)
    {
        return view('admin.chapter.files', [
            'chapter' => $chapter
        ]);
    }

    public function themes(Chapter $chapter)
    {
        return view('admin.chapter.themes', [
            'chapter' => $chapter
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'title' => 'required|max:255',
            'order' => 'integer|nullable'
        ],
            [
                'title.required' => 'Поле название должно быть заполено!',
                'max' => 'Максимальная длина параметра 255 символов!',
                'order.integer' => 'Номер должен быть целым числом',
            ]);

        Chapter::create([
            'title' => $request->get('title'),
            'order' => $request->get('order'),
            'course_id' => $request->get('course_id')
        ]);

        return redirect()
            ->route('course.chapters', $request->get('course_id'))
            ->with('success', 'Модуль успешно добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Chapter $chapter
     * @return \Illuminate\Http\Response
     */
    public function show(Chapter $chapter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Chapter $chapter
     * @return \Illuminate\Http\Response
     */
    public function edit(Chapter $chapter)
    {
        //
    }

    public function editOfCourse(Course $course, Chapter $chapter)
    {
        return view('admin.chapter.edit', [
            'course' => $course,
            'chapter' => $chapter,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Chapter $chapter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chapter $chapter)
    {
        $validator = $request->validate([
            'title' => 'required|max:255',
            'order' => 'integer|nullable'
        ],
            [
                'title.required' => 'Поле название должно быть заполено!',
                'max' => 'Максимальная длина параметра 255 символов!',
                'order.integer' => 'Номер должен быть целым числом',
            ]);

        $chapter->title = $request->get('title');
        $chapter->order = $request->get('order');
        $chapter->save();

        return redirect()
            ->route('course.chapters', $request->get('course_id'))
            ->with('success', 'Модуль успешно отредактирован');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Chapter $chapter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chapter $chapter)
    {
        $chapter->delete();

        return redirect()->back()->withSuccess('Модуль успешно удален!');
    }
}
