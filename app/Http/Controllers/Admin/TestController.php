<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestStoreRequest;
use App\Http\Requests\TestUpdateRequest;
use App\Http\Resources\TestResource;
use App\Models\Test;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
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

    public function createOfTheme(Theme $theme)
    {
        return view('admin.test.create', [
            'theme' => $theme,
        ]);
    }

    public function questions(Test $test)
    {
        return view('admin.test.questions', [
            'test' => $test
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestStoreRequest $request)
    {
        $test = Test::create($request->validated());

        foreach ($request->questions as $key => $question) {
            $question = Question::create([
                'content' => $question['content'],
                'test_id' => $test->id,
                'type' => $question['type'],
                'correct' => json_encode($question['correct']),
                'answers' => json_encode($question['answers']),
                'img_url' => $question['img_url'],
                'comment' => $question['comment'],
            ]);
        }
        return new TestResource($test);
    }

    /*public function store(Request $request)
    {
        $validator = $request->validate([
            'min_correct' => 'required|integer',
            'minutes' => 'required|integer'
        ],
            [
                'min_correct.required' => 'Поле минимальное количество верных ответов должно быть заполено!',
                'minutes.required' => 'Поле минуты должно быть заполено!',
                'integer' => 'Укажите целое число!',
            ]);

        Test::create([
            'min_correct' => $request->get('min_correct'),
            'minutes' => $request->get('minutes'),
            'chapter_id' => $request->get('chapter_id')
        ]);

        return redirect()
            ->route('chapter.tests', $request->get('chapter_id'))
            ->with('success', 'Тест успешно добавлен');
    }*/

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        return new TestResource($test);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        //
    }

    public function editOfTheme(Theme $theme, Test $test)
    {
        return view('admin.test.edit', [
            'test' => $test,
            'theme' => $theme,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(TestUpdateRequest $request, Test $test)
    {
        foreach ($test->questions as $key => $question) {
            $question->delete();
        }

        $test->update($request->validated());

        foreach ($request->questions as $key => $question) {
            Question::create([
                'content' => $question['content'],
                'test_id' => $test->id,
                'type' => $question['type'],
                'correct' => json_encode($question['correct']),
                'answers' => json_encode($question['answers']),
                'img_url' => $question['img_url'],
                'comment' => $question['comment'],
            ]);
        }

        return new TestResource($test);
    }
    /*public function update(Request $request, Test $test)
    {
        $validator = $request->validate([
            'min_correct' => 'required|integer',
            'minutes' => 'required|integer'
        ],
            [
                'min_correct.required' => 'Поле минимальное количество верных ответов должно быть заполено!',
                'minutes.required' => 'Поле минуты должно быть заполено!',
                'integer' => 'Укажите целое число!',
            ]);


            $test->min_correct = $request->get('min_correct');
            $test->minutes = $request->get('minutes');
            $test->save();

        return redirect()
            ->route('chapter.tests', $request->get('chapter_id'))
            ->with('success', 'Тест успешно отредактирован');
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        $test->delete();

        return redirect()->back()->withSuccess('Тест успешно удален!');
    }

    public function results(Test $test)
    {
        $users = User::whereIn('id', $test->theme->chapter->course->studentsIds())->get();

        return view('admin.test.results', [
            'test' => $test,
            'users' => $users
        ]);
    }

    public function userAttempts(Test $test, User $user)
    {
        $attempts = $test->attempts->where('user_id', $user->id);

        return view('admin.test.attempts', [
            'test' => $test,
            'user' => $user,
            'attempts' => $attempts
        ]);
    }

    public function imageSave(Request $request)
    {
        $request->validate(
            [
                'image' => 'image|mimes:jpg,jpeg,png,gif,bmp'
            ],
            [
                'mimes' => 'Изображение должно быть в формате jpg,jpeg,png,gif,bmp',
                'image' => 'Файл не является изображением'
            ]
        );

        $title = (string) Str::uuid();
        $extension = $request->image->getClientOriginalExtension();
        $filename = $title . "." . $extension;
        $request->image->storeAs('images/questions', $filename, 'public');

        return '/storage/images/questions/' . $filename;
    }

    public function imageDelete(Request $request)
    {
        if (!$request->img_url) {
            return response()->noContent(201);
        }

        $img_url = str_replace('/storage/', 'public/', $request->img_url);

        if (Storage::exists($img_url)) {
            Storage::delete($img_url);
        }

        return response()->noContent(201);
    }
}
