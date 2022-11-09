<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
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

    public function createOfChapter(Chapter $chapter)
    {
        return view('admin.theme.create', [
            'chapter' => $chapter,
        ]);
    }

    public function tests(Theme $theme)
    {
        return view('admin.theme.tests', [
            'theme' => $theme
        ]);
    }

    public function files(Theme $theme)
    {
        return view('admin.theme.files', [
            'theme' => $theme
        ]);
    }

    public function videos(Theme $theme)
    {
        return view('admin.theme.videos', [
            'theme' => $theme
        ]);
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
            'title' => 'required|max:255',
            'order' => 'integer|nullable'
        ],
            [
                'title.required' => 'Поле название должно быть заполено!',
                'max' => 'Максимальная длина параметра 255 символов!',
                'order.integer' => 'Номер должен быть целым числом',
            ]);

        Theme::create([
            'title' => $request->get('title'),
            'order' => $request->get('order'),
            'chapter_id' => $request->get('chapter_id')
        ]);

        return redirect()
            ->route('chapter.themes', $request->get('chapter_id'))
            ->with('success', 'Тема успешно добавлена');
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
    public function edit(Theme $theme)
    {
        //
    }

    public function editOfChapter(Chapter $chapter, Theme $theme)
    {
        return view('admin.theme.edit', [
            'theme' => $theme,
            'chapter' => $chapter,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Theme $theme)
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

        $theme->title = $request->get('title');
        $theme->order = $request->get('order');
        $theme->save();

        return redirect()
            ->route('chapter.themes', $request->get('chapter_id'))
            ->with('success', 'Тема успешно отредактирована');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Theme $theme)
    {
        $theme->delete();

        return redirect()->back()->withSuccess('Тема успешно удалена!');
    }
}
