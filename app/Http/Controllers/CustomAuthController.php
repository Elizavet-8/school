<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Exception;

class CustomAuthController extends Controller
{
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect("/home");
        }

        try {
            $response = Http::post("https://api.rosvuz.ru/sdo/login", [
                "login" => $request->email,
                "password" => $request->password
            ]);

            $user = $this->createUser($credentials, $response->json());
            $school = $this->createSchool($response->json()['school']);
            $user->school_id = $school->id ?? null;
            $user->save();

            if (Auth::login($user)) {
                return redirect("/home");
            }
        } catch (Exception $e) {
            report($e);
            return back()->withErrors([
                'email' => 'Введенные учетные данные не соответствуют нашим записям.'
            ])->withInput();
        }


//        return redirect()->back()->withErrors([
//            'email' => 'Введенные учетные данные не соответствуют нашим записям.'
//        ]);
    }

    private function createUser($credentials, $userData): User
    {
        $user = User::where('email', $credentials['email'])->first();

        if ($user) {
            return $user;
        }

        $birth = $userData['birth'] == "" ? null : $userData['birth'];

        $user = new User;
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);
        $user->name = $userData['name'];
        $user->grade = $userData['grade'];
        $user->img_url = $userData['avatar'];
        $user->city = $userData['city'];
        $user->birth = $birth;
        $user->save();

        if ($userData['role'] == "teacher") {
            $user->assignRole('teacher');
        }

        if ($userData['role'] == "student") {
            $user->assignRole('student');
        }

        if ($userData['role'] == "parent") {
            $user->assignRole('parent');
        }

        if ($userData['role'] == "") {
            $user->assignRole('individual');
        }

        return $user;
    }

    private function createSchool($schoolData)
    {
        if ($schoolData['id'] == null) {
            return null;
        }

        $school = School::where('rosvuz_id', $schoolData['id'])->first();

        if ($school) {
            return $school;
        }

        $school = new School;
        $school->title = $schoolData['title'];
        $school->rosvuz_id = $schoolData['id'];
        $school->save();

        return $school;
    }
}
