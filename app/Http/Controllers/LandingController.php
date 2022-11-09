<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\LandingApplicationMail;
use App\Mail\LandingCall;

class LandingController extends Controller
{
    public function subjects(Request $request)
    {
        try {
            return Course::where('grade', $request->grade)->get();
        } catch (Exception $th) {
            return [];
        }
    }

    public function modules(Request $request)
    {
        try {
            return Chapter::where('course_id', $request->subject)->with('themes')->get();
        } catch (Exception $th) {
            return [];
        }
    }

    public function signup(Request $request)
    {
        $data = array(
            'fio' => $request->get('fio'), 
            'phone' => $request->get('phone'), 
            'email' => $request->get('email'), 
            'place' => $request->get('place'),
            'grade' => $request->get('grade'),
            'program' => $request->get('program'),
            // 'additional' => $request->get('additional'),
            // 'consult' => $request->get('consult'),
        );
        
        Mail::to('dima.rosvuz@yandex.ru')->send(new LandingApplicationMail($data, 'Заявка на регистрацию'));
    }

    public function orderCall(Request $request)
    {
        $data = array(
            'name' => $request->get('name'), 
            'phone' => $request->get('phone'), 
        );
        
        Mail::to('dima.rosvuz@yandex.ru')->send(new LandingCall($data, 'Заявка на обратный звонок'));
    }
}
