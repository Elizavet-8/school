<?php

namespace App\Http\Controllers;

use App\Models\Practical;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Chapter;
use App\Models\Section;
use App\Models\Theme;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
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

    public function isAvailable(Course $course): bool
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('teacher')) {
            return true;
//            if ($course->user_id == $user->id || $course->users()->find($user->id)) {
//                return true;
//            }
        }

        if ($user->hasRole('student') && ($course->grade == $user->grade && $user->school && $course->schools->where('id', $user->school->id))) {
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $courses = [];
        $user = Auth::user();

        if ($user->hasRole('parent')) {
            $courses = Course::where("id", 0)->paginate(10);
            return view('home', compact('courses'));
        }

        $school = $user->school;

        $courses = Course::when($user->hasRole('student'), function ($query) use ($user) {
            return $query->whereHas('schools', function ($query) use ($user) {
                if ($user->school) {
                    return $query->where('school_id', ($user->school->id));
                }
            })->where('grade', $user->grade);
        })->when($user->hasRole('teacher'), function ($query) use ($user) {
            return $query->orWhere('user_id', $user->id);
        })->when($user->hasRole('individual'), function ($query) use ($user) {
            return $query->orWhereIn('id', $user->availableCourses);
        })->paginate(10);

        /*if ($school && $user->grade) {
            $courses = $school->courses->where('grade', $user->grade);
        }

        if ($user->hasRole('teacher')) {
            $teacherCourses = $user->courses;
            $courses = array_unique([...$courses, ...$teacherCourses]);
        }*/

        //$courses = Course::all();
        return view('home', compact('courses'));
    }

    public function course(Course $course, Request $request)
    {
        if (!$this->isAvailable($course)) {
            return redirect("/home");
        }

        return view('course', [
            'course' => $course,
        ]);
    }

    public function materials(Theme $theme, Section $section)
    {
        if (!$this->isAvailable($theme->chapter->course)) {
            return redirect("/home");
        }

        $materials = $theme->files
            ->where('section_id', $section->id)
            ->whereIn('type', ["doc", "pdf", "docx"]);

        return view('materials', [
            'theme' => $theme,
            'materials' => $materials,
            'section' => $section
        ]);
    }

    public function allMaterials(Theme $theme)
    {
        if (!$this->isAvailable($theme->chapter->course)) {
            return redirect("/home");
        }

        $materials = $theme->files
            ->whereIn('type', ["doc", "pdf", "docx"]);

        return view('all_materials', [
            'theme' => $theme,
            'materials' => $materials,
        ]);
    }

    public function presentations(Theme $theme, Section $section)
    {
        if (!$this->isAvailable($theme->chapter->course)) {
            return redirect("/home");
        }

        $materials = $theme->files
            ->where('section_id', $section->id)
            ->whereIn('type', ["ppt", "pptx"]);

        return view('presentations', [
            'theme' => $theme,
            'materials' => $materials,
            'section' => $section
        ]);
    }

    public function allPresentations(Theme $theme)
    {
        if (!$this->isAvailable($theme->chapter->course)) {
            return redirect("/home");
        }

        $materials = $theme->files
            ->whereIn('type', ["ppt", "pptx"]);

        return view('all_presentations', [
            'theme' => $theme,
            'materials' => $materials,
        ]);
    }

    public function tests(Theme $theme, Section $section)
    {
        if (!$this->isAvailable($theme->chapter->course)) {
            return redirect("/home");
        }

        $tests = $theme->tests
            ->where('section_id', $section->id);

        return view('tests', [
            'theme' => $theme,
            'tests' => $tests,
            'section' => $section
        ]);
    }

    public function allTests(Theme $theme)
    {
        if (!$this->isAvailable($theme->chapter->course)) {
            return redirect("/home");
        }

        $tests = $theme->tests;

        return view('all_tests', [
            'theme' => $theme,
            'tests' => $tests,
        ]);
    }

    public function allPracticals(Theme $theme)
    {
        if (!$this->isAvailable($theme->chapter->course)) {
            return redirect("/home");
        }

        return view('all_practicals', [
            'theme' => $theme
        ]);

    }

    public function onePractical(Theme $theme, Practical $practical)
    {
        $sections = Section::all();
        $comments = Comment::where("user_id", Auth::user()->id)
            ->where("teacher_id", $practical->user_id)
            ->get();
//        $comments = \App\Models\Comment::query()
//            ->where("user_id", Auth::user()->id)
//            ->where("teacher_id", $practical->user_id)->get();
//        foreach ($comments as $comment)


        return view('practicals', [
            'theme' => $theme,
            'sections' => $sections,
            'practical' => $practical,
            'comments' => $comments,
        ]);
    }

    public function videos(Theme $theme, Section $section)
    {
        if (!$this->isAvailable($theme->chapter->course)) {
            return redirect("/home");
        }

        $materials = $theme->files
            ->where('section_id', $section->id)
            ->whereIn('type', ["video"]);

        return view('videos', [
            'theme' => $theme,
            'materials' => $materials,
            'section' => $section
        ]);
    }

    public function allVideos(Theme $theme)
    {
        if (!$this->isAvailable($theme->chapter->course)) {
            return redirect("/home");
        }

        $materials = $theme->files
            ->whereIn('type', ["video"]);

        return view('all_videos', [
            'theme' => $theme,
            'materials' => $materials,
        ]);
    }

    public function menu(Theme $theme)
    {
        if (!$this->isAvailable($theme->chapter->course)) {
            return redirect("/home");
        }

        $tests = $theme->tests;
        $files = $theme->files;

        $is_theory = $tests->where('section_id', 1)->count() > 0 || $files->where('section_id', 1)->count() > 0;
        $is_materials = $tests->where('section_id', 2)->count() > 0 || $files->where('section_id', 2)->count() > 0;
        $is_practice = $tests->where('section_id', 3)->count() > 0 || $files->where('section_id', 3)->count() > 0;
        $is_home = $tests->where('section_id', 4)->count() > 0 || $files->where('section_id', 4)->count() > 0;
        $is_control = $tests->where('section_id', 5)->count() > 0 || $files->where('section_id', 5)->count() > 0;
//        $is_practicals = $tests->where('section_id', 6)->count() > 0 || $files->where('section_id', 6)->count() > 0 ;

        return view('menu', compact('theme', 'is_theory', 'is_materials', 'is_practice', 'is_home', 'is_control'));
    }

    public function settings()
    {
        return view('settings');
    }

    public function test()
    {
        return view('test');
    }

    public function testShow()
    {
        return view('main-test');
    }

    public function other()
    {
        $user = Auth::user();

        if (!$user->hasRole('teacher|admin')) {
            return redirect("/home");
        }

        $courses = Course::where('user_id', '!=', $user->id)->paginate(10);

        return view('other', compact('courses'));
    }

    public function searchGrade(Request $request)
    {
        $search_grade = $request->search_grade;

        $per_page = $request->get('per_page', 5);
        $courses = Course::where('grade', 'LIKE', '%'.$search_grade.'%')->orderBy('grade')->
        sortable()->simplePaginate($request->get('per_page', 5));

        return view('other', compact('courses', 'per_page'));
    }


}
