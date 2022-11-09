<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\DenyMail;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class ApplicationController extends Controller
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
        $applications = Application::sortable()->simplePaginate(20);

        return view('admin.application.index', compact('applications'));
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
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        $application->delete();
        return redirect()->back()->withSuccess('Заявка была успешно удалена!');
    }

    public function accept(Application $application)
    {
        $roles = Role::all();

        return view('admin.application.accept', [
            'roles' => $roles,
            'application' => $application
        ]);
    }

    public function deny(Application $application)
    {
        return view('admin.application.deny', [
            'application' => $application
        ]);
    }

    public function sendDenyEmail(Request $request)
    {
        $application = Application::find($request->get('application_id'));

        //$data = array('reason' => $request->get('reason'));
        //Mail::to($application->email)->send(new DenyMail($data, 'Отказ в получении доступа'));

        $application->status = 'не принята';
        $application->save();

        return redirect()->back()->withSuccess('Отказ успешно отправлен!');
    }

    public function postpone (Application $application)
    {
        $application->status = 'отложена';
        $application->save();

        return redirect()->back()->withSuccess('Заявка успешно отложена!');
    }
}
