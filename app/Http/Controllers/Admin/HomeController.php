<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attempt;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user->hasRole('admin')) {
            return redirect('/admin/course');
        }

        $users_count = User::count();
        $users_attempts = Attempt::count();
        return view('admin.home.index', [
            'users_count' => $users_count,
            'users_attempts' => $users_attempts
        ]);
    }
}
