<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Providers\RouteServiceProvider;

class GuestController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function application()
    {
        if (auth()->user()) 
        {
            return redirect(route('home'));
        }
        else
        {
            return view('application');
        }
    }
}
