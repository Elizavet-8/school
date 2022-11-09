<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Application;
use App\Mail\WelcomeMail;
use App\Models\Course;
use App\Models\School;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|teacher');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::sortable()->simplePaginate(20);
        $schools = School::all();

        return view('admin.user.index', compact('users', 'schools'));
    }

    public function experts()
    {
        $users = User::role('teacher')->sortable()->simplePaginate(20);

        return view('admin.user.index', compact('users'));
    }

    public function admins()
    {
        $users = User::role('admin')->sortable()->simplePaginate(20);

        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $schools = School::all();
        $permissions = Permission::all();

        return view('admin.user.create', [
            'roles' => $roles,
            'permissions' => $permissions,
            'schools' => $schools
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
            'name' => 'required|max:255',
            'email' => 'required|unique:users|email|max:255',
            'password' => 'required|max:255',
            'city' => 'max:255',
            'grade' => 'integer|min:1|nullable',
            'image' => 'mimes:jpg,jpeg,png,gif,bmp'
        ],
            [
                'name.required' => 'Поле имя должно быть заполено!',
                'email.required' => 'Поле e-mail должно быть заполено!',
                'email.unique' => 'Пользователь с таким e-mail уже существует!',
                'email.email' => 'e-mail указан в неверном формате!',
                'password.required' => 'Поле пароль должно быть заполено!',
                'max' => 'Максимальная длина параметра 255 символов!',
                'min' => 'Минимальное значение класса 1',
                'grade.integer' => 'Класс должен быть целым числом',
                'mimes' => 'Изображение должно быть в формате jpg,jpeg,png,gif,bmp'
            ]);

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'city' => $request->get('city'),
            'birth' => $request->get('birth'),
            'sex' => $request->get('sex'),
            'school_id' => $request->get('school_id'),
            'grade' => $request->get('grade'),
        ]);

        if ($request->has('application_id')) {
            $application = Application::find($request->get('application_id'));
            $application->status = 'принята';
            $application->save();
        }

        if ($request->hasFile('image')) {
            $filename = $request->image->getClientOriginalName();
            $request->image->storeAs('images/users/' . $user->id, $filename, 'public');
            $user->update(['img_url' => "/storage/images/users/" . $user->id . "/" . $filename]);
        }

        $user->syncRoles($request->get('roles'));
        $user->syncPermissions($request->get('permissions'));

        //$data = array('login' => $request->get('login'), 'password' => $request->get('password'));
        //Mail::to($user->email)->send(new WelcomeMail($data, 'Заявка принята!'));

        return redirect()
            ->route('user.index')
            ->with('success', 'Пользователь успешно добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $schools = School::all();
        $courses = Course::with('users')->get();
        $permissions = Permission::all();

        return view('admin.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'schools' => $schools,
            'courses' => $courses
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = $request->validate(
            [
                'name' => 'required|max:255',
                'email' => ['email', 'max:255', 'required', Rule::unique('users')->ignore($user->id)],
                'city' => 'max:255',
                'image' => 'image|mimes:jpg,jpeg,png,gif,bmp',
                'grade' => 'integer|min:1|nullable'
            ],
            [
                'name.required' => 'Поле имя должно быть заполено!',
                'email.required' => 'Поле e-mail должно быть заполено!',
                'email.unique' => 'Пользователь с таким e-mail уже существует!',
                'email.email' => 'e-mail указан в неверном формате!',
                'max' => 'Максимальная длина параметра 255 символов!',
                'min' => 'Минимальное значение класса 1',
                'grade.integer' => 'Класс должен быть целым числом',
                'mimes' => 'Изображение должно быть в формате jpg,jpeg,png,gif,bmp'
            ]
        );

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->city = $request->get('city');
        $user->birth = $request->get('birth');
        $user->sex = $request->get('sex');
        $user->school_id = $request->get('school_id');
        $user->grade = $request->get('grade');
        $user->save();

        if ($request->hasFile('image')) {
            $filename = $request->image->getClientOriginalName();
            if (Storage::exists('public/images/users/' . $user->id)) {
                $files = Storage::allFiles('public/images/users/' . $user->id);
                Storage::delete($files);
            }
            $request->image->storeAs('images/users/' . $user->id, $filename, 'public');
            $user->update(['img_url' => "/storage/images/users/" . $user->id . "/" . $filename]);
        }

        $user->syncRoles($request->get('roles'));
        $user->syncPermissions($request->get('permissions'));

        $user->availableCourses()->sync($request->get('courses'));

        return redirect()
            ->route('user.index')
            ->with('success', 'Пользователь успешно отредактирован');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        if (Storage::exists('public/images/users/' . $user->id)) {
            Storage::deleteDirectory('public/images/users/' . $user->id);
        }
        return redirect()->back()->withSuccess('Пользователь был успешно удален!');
    }

    public function courses(User $user)
    {
        $courses = [];
        $school = $user->school;
        $userAuth = Auth::user();

        if ($school && $user->grade) {
            $courses = $school->courses->where('grade', $user->grade);
        }

        if ($userAuth->hasRole('teacher') && !$userAuth->hasRole('admin')) {
            $courses = $courses->where('user_id', $userAuth->id);
        }

        return view('admin.user.courses', [
            'courses' => $courses,
            'user' => $user
        ]);
    }

    public function tests(User $user, Course $course)
    {
        $tests = [];

        foreach ($course->chapters as $chapter) {
            foreach ($chapter->themes as $theme) {
                array_push($tests, ...$theme->tests );
            }
        }

        return view('admin.user.tests', [
            'course' => $course,
            'tests' => $tests,
            'user' => $user
        ]);
    }

    public function attempts(User $user, Test $test)
    {
        $attempts = $test->attempts->where('user_id', $user->id);

        return view('admin.user.attempts', [
            'test' => $test,
            'user' => $user,
            'attempts' => $attempts
        ]);
    }
}
