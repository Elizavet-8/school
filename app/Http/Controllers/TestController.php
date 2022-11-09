<?php

namespace App\Http\Controllers;

use App\Http\Resources\TestResource;
use App\Models\Attempt;
use App\Models\Course;
use App\Models\Question;
use App\Models\Section;
use App\Models\Test;
use App\Services\TestCheckService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function isAvailable(Course $course) : bool
    {
        $user = Auth::user();

        if (($user->hasRole('teacher') && $user->courses->contains($course->id)) || $course->users()->find($user->id)) {
            return true;
        }

        if ($user->hasRole('student') && $course->grade == $user->grade && $user->school && $course->schools->where('id', $user->school->id)) {
            return true;
        }

        if ($user->hasRole('student') && $course->users()->find($user->id)) {
            return true;
        }

        if ($user->hasRole('individual') && $course->users()->find($user->id)) {
            return true;
        }

        return false;
    }

    public function testBefore(Test $test)
    {
        if (!$this->isAvailable($test->theme->chapter->course)) {
            return redirect("/home");
        }

        return view('test-before', [
            'test' => $test
        ]);
    }

    public function testResult(Attempt $attempt)
    {
        return view('test-result', [
            'test' => $attempt->test,
            'attempt' => $attempt,
        ]);
    }

    public function test(Test $test)
    {
        /*$attempt = Attempt::create([
            'user_id' => Auth::user()->id,
            'test_id' => $test->id,
            'finished_at' => Carbon::now()->addMinute($test->minutes),
            'correct' => 0,
            'questions' => $test->questions->count(),
            'is_passed' => false
        ]);*/

        if (!$this->isAvailable($test->theme->chapter->course)) {
            return redirect("/home");
        }

        $user = Auth::user();

        if (!$test->isAvailable($user)) {
            return redirect()->route('test.about', [$test]);
        }

        return view('test-prod', [
            'test' => $test,
            //'attempt' => $attempt
        ]);
    }

    public function testJson(Test $test)
    {
        return new TestResource($test);
    }

    public function complete(Request $request)
    {
        $attempt = Attempt::create([
            'user_id' => Auth::user()->id,
            'test_id' => $request->test_id,
            'correct' => $request->correct,
            'questions' => $request->questions,
            'is_passed' => $request->is_passed
        ]);

        $test = Test::where('id', $request->test_id)->first();

        if (!$test) {
            return $attempt;
        }

        if ($test->isAvailable(Auth::user())) {
            $attempt->available = true;
        } else {
            $attempt->available = false;
        }

        return $attempt;
    }

    public function startTest(Test $test)
    {
        /*$attempt = Attempt::where('test_id', $test->id)->
                            where('is_finished', false)->
                            where('user_id', Auth::user()->id)->
                            where('finished_at', '>', Carbon::now())->
                            first();*/

        //if (!$attempt) {
        $attempt = Attempt::create([
            'user_id' => Auth::user()->id,
            'test_id' => $test->id,
            'finished_at' => Carbon::now()->addMinute($test->minutes),
            'correct' => 0,
            'questions' => $test->questions->count(),
            'is_passed' => false,
            'is_finished' => false,
        ]);
        //}

        return $attempt;
    }

    public function validatateTestResult(Request $request, Attempt $attempt): Attempt
    {
        $attempt->answers = json_encode($request->answer_list);
        $attempt->is_finished = true;
        $attempt->finished_at = Carbon::now();

        $testCheckService = new TestCheckService($request->answer_list, $attempt->testWithQuestions);
        $sumOfCorrectAnswers = $testCheckService->checkTest();
        $neededCorrectAnswers = $attempt->test->min_correct;

        //dd($result);

        // список ответов пользователя пуст
        //        if (count($request->answer_list) == 0) {
        //            $attempt->save();
        //            return $attempt;
        //        }

        // счетчик правильных ответов
        //        $sum_of_correct_answers = 0;
        //        $needed_correct_answers = $attempt->test->min_correct;

        // цикл по всем ответам на тест
        /*foreach ($request->answer_list as $key => $answer_list_item) {
            $question_id = $request->answer_list[$key]['question_index'];
            // вопрос из базы с правильным ответом
            $question = Question::find($question_id);

            // если нет вопроса - создать
//            if (!$question) {
//                Question::create([
//                    'test_id' => $attempt->test->id,
//                    'settings' => '{}',
//                    'data' => '{}',
//                    'correct' => json_encode($request->answer_list[$key]['answer']),
//                ]);
//                continue;
//            }

            // список верных ответов на конкретный вопрос
            $correct_answers = json_decode($question->correct);

            // сколько всего ответов в массиве ответов
            $total = count($correct_answers);

            // если количество ответов и верных ответов не совпадает - продолжаем
            if ($total != count($request->answer_list[$key]['answer'])) {
                continue;
            }

            // количество верных ответов
            $correct = 0;

            // цикл по всем ответам на вопрос
            foreach ($request->answer_list[$key]['answer'] as $index => $answer) {
                // правильный ответ
                $correct_answer = $correct_answers[$index]->result;
                // ответ пользователя
                $user_answer = $answer['result'];

                if (is_array($correct_answer)) {
                    $count_correct_items = count($correct_answer);
                    $count_check_items = 0;

                    foreach ($correct_answer as $key => $value) {
                        if ($this->in_array_to_lower($value, $user_answer)) {
                            $count_check_items++;
                        }
                    }

                    if ($count_correct_items == $count_check_items) {
                        $correct++;
                    }
                } else {
                    $correct_string = mb_strtolower($correct_answer);
                    $current_string = mb_strtolower($user_answer);
                    $correct_string = str_replace(".", "", $correct_string);
                    $current_string = str_replace(".", "", $current_string);
                    $correct_string = str_replace(" ", "", $correct_string);
                    $current_string = str_replace(" ", "", $current_string);

                    if ($correct_string === $current_string) {
                        $correct++;
                    }
                }
            }

            if ($total === $correct) {
                $sum_of_correct_answers++;
            }
        }*/

        $attempt->correct = $sumOfCorrectAnswers;

        if ($sumOfCorrectAnswers >= $neededCorrectAnswers) {
            $attempt->is_passed = true;
        }

        $attempt->save();

        $course = $attempt->test->chapter->course;

        /*$user = $course->users()->find(Auth::user()->id);

        if ($user) {
            $course->users()->updateExistingPivot($user, ['completed' => $course->completeCheck()], false);
        } else {
            $course->users()->attach(Auth::user()->id, ['completed' => 1]);
        }*/

        return $attempt;
    }

    /*function in_array_to_lower($needle, $haystack) {
        $search = str_replace(".", "", $needle);
        $search = str_replace(" ", "", $search);
        $data = array_map(function($value) { return str_replace('.', '', $value); }, $haystack);
        $data = array_map(function($value) { return str_replace(' ', '', $value); }, $data);
        return in_array(strtolower($search), array_map('strtolower', $data));
    }*/
}
