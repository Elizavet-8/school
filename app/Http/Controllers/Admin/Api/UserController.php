<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $course = Course::first();
        $user = Auth::user();

        $filters = (object) [
            'name' => $request->name,
            'school_id' => $request->school_id,
            'grade' => $request->grade
        ];

        $users = User::when($user->hasRole('teacher'), function ($query) use ($user) {
            if (!$user->hasRole('admin')) {
                $query->whereIn('id', $user->studentsIds());
            }
        })->withFilters(
            $filters
        )->orderByRaw('name DESC')->paginate(20);

        return new UserCollection($users);
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
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id == Auth::id()) {
            return;
        }

        $user = User::where("id", $id)->first();

        foreach ($user->courses as $key => $course) {
            $course->user_id = 1;
            $course->save();
        }

        $user->delete();
    }
}
