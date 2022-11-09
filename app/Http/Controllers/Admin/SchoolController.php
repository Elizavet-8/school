<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = School::sortable()->simplePaginate(20);

        return view('admin.school.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.school.create');
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
        ],
        [
            'title.required' => 'Поле название должно быть заполено!',
            'max' => 'Максимальная длина параметра 255 символов!',
        ]);

        School::create([
            'title' => $request->get('title'),
        ]);

        return redirect()
            ->route('school.index')
            ->with('success', 'Учебное заведение успешно добавлено');
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
    public function edit(School $school)
    {
        return view('admin.school.edit', [
            'school' => $school,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $school)
    {
        $validator = $request->validate([
            'title' => 'required|max:255',
        ],
        [
            'title.required' => 'Поле название должно быть заполено!',
            'max' => 'Максимальная длина параметра 255 символов!',
        ]);

        $school->title = $request->get('title');
        $school->save();

        return redirect()
            ->route('school.index')
            ->with('success', 'Учебное заведение успешно отредактировано');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->back()->withSuccess('Учебное заведение было успешно удалено!');
    }
}
