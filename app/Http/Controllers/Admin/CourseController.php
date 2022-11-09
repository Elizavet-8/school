<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Curriculum;
use App\Models\Practical;
use App\Models\School;
use App\Models\Section;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Exceptions\UnauthorizedException;
use DB;

use App\Exports\CourseExport;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('role:admin')->only('destroy','create', 'store');
        $this->middleware('permission:создание курсов')->only('create', 'store');
        $this->middleware('permission:редактирование курсов')->only('update', 'edit');
        $this->middleware('permission:удаление курсов')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $per_page = $request->get('per_page', 20);
        if ($user->hasRole('admin')) {
            $courses = Course::sortable()->simplePaginate($per_page);
        } else {
            $courses = Course::where('user_id', $user->id)->sortable()->simplePaginate($request->get('per_page', 25));
        }

        $courses->appends(['per_page' => $per_page]);


        return view('admin.course.index', compact('courses', 'per_page'));
    }

    public function searchTeachers(Request $request)
    {
        $search_teachers = $request->search_teachers;

        $per_page = $request->get('per_page', 20);

        $courses = Course::join('users', 'courses.user_id', '=', 'users.id' )
            ->where('users.name', 'LIKE', '%'.$search_teachers.'%')
            ->select(DB::raw("`users`.*, `courses`.*"))
            ->sortable()->simplePaginate($request->get('per_page', 25));

        return view('admin.course.index', compact('courses', 'per_page'));
    }


    public function searchCourses(Request $request)
    {
        $search_courses = $request->search_courses;

        $per_page = $request->get('per_page', 20);
        $courses = Course::where('title', 'LIKE', '%'.$search_courses.'%')->orderBy('title')->
        sortable()->simplePaginate($request->get('per_page', 25));

        return view('admin.course.index', compact('courses', 'per_page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teachers = User::role('teacher')->get();
        $schools = School::all();
        $curricula = Curriculum::all();

        return view('admin.course.create', [
            'teachers' => $teachers,
            'schools' => $schools,
            'curricula' => $curricula
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
            'image' => 'mimes:jpg,jpeg,png,gif,bmp',
            'user_id' => 'exists:App\Models\User,id',
            'grade' => 'integer|min:1|nullable',
            'hours' => 'integer|min:1|nullable',
        ],
            [
                'title.required' => 'Поле название должно быть заполено!',
                'max' => 'Максимальная длина параметра 255 символов!',
                'mimes' => 'Изображение должно быть в формате jpg,jpeg,png,gif,bmp',
                'exists' => 'Пользователь не найден, возможно он был удален',
                'grade.integer' => 'Класс должен быть целым числом',
                'hours.integer' => 'Часы должны быть целым числом',
            ]);

        $course = Course::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'hours' => $request->get('hours'),
            'user_id' => $request->get('user_id'),
            'grade' => $request->get('grade'),
        ]);

        if ($request->hasFile('image')) {
            $filename = $request->image->getClientOriginalName();
            $request->image->storeAs('images/courses/' . $course->id, $filename, 'public');
            $course->update(['img_url' => "/storage/images/" . $course->id . "/" . $filename]);
        }

        $course->schools()->sync($request->get('schools'));
        $course->curricula()->sync($request->get('curricula'));

        return redirect()
            ->route('course.index')
            ->with('success', 'Курс успешно добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $teachers = User::role('teacher')->get();
        $schools = School::all();
        $curricula = Curriculum::all();

        return view('admin.course.edit', [
            'course' => $course,
            'teachers' => $teachers,
            'schools' => $schools,
            'curricula' => $curricula
        ]);
    }

    public function chapters(Course $course)
    {
        return view('admin.course.chapters', [
            'course' => $course
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $validator = $request->validate([
            'title' => 'required|max:255',
            'image' => 'mimes:jpg,jpeg,png,gif,bmp',
            'user_id' => 'exists:App\Models\User,id',
            'grade' => 'integer|min:1|nullable',
            'hours' => 'integer|min:1|nullable',
        ],
            [
                'title.required' => 'Поле название должно быть заполено!',
                'max' => 'Максимальная длина параметра 255 символов!',
                'mimes' => 'Изображение должно быть в формате jpg,jpeg,png,gif,bmp',
                'exists' => 'Пользователь не найден, возможно он был удален',
                'grade.integer' => 'Класс должен быть целым числом',
                'hours.integer' => 'Часы должны быть целым числом',
            ]);

        $course->title = $request->get('title');
        $course->description = $request->get('description');
        $course->user_id = $request->get('user_id');
        $course->hours = $request->get('hours');
        $course->grade = $request->get('grade');
        $course->save();

        if ($request->hasFile('image')) {
            $filename = $request->image->getClientOriginalName();
            if (Storage::exists('public/images/courses/' . $course->id)) {
                $files = Storage::allFiles('public/images/courses/' . $course->id);
                Storage::delete($files);
            }
            $request->image->storeAs('images/courses/' . $course->id, $filename, 'public');
            $course->update(['img_url' => "/storage/images/courses/" . $course->id . "/" . $filename]);
        }

        $course->schools()->sync($request->get('schools'));
        $course->curricula()->sync($request->get('curricula'));

        return redirect()
            ->route('course.index')
            ->with('success', 'Курс успешно отредактирован');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->back()->withSuccess('Курс был успешно удален!');
    }

    public function CourseExport()
    {
        return Excel::download(new CourseExport(), 'course.xlsx');
//        Excel::store(new CourseExport(), 'course.xlsx');
//        return Storage::get('course.xlsx');
    }
}
