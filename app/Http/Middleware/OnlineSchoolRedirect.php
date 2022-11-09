<?php

namespace App\Http\Middleware;

use App\Models\School;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class OnlineSchoolRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();
        $uri = $route->uri;

        if ($uri != "login") {
            return $next($request);
        }

        $secret = $request->secret;

        if (!$secret) {
            return $next($request);
        }

        $email = $this->XORCipher($secret, 'rosvuz2021sdo', false);

        $user = User::where('email', $email)->first();

        if ($user) {
            Auth::login($user);
        } else {
            $response = Http::post("https://api.rosvuz.ru/sdo/login", [
                "login" => $email,
                "password" => $secret
            ]);

            if ($response->ok()) {
                $user = $this->createUser($email, $response->json());
                $school = $this->createSchool($response->json()['school']);
                $user->school_id = $school->id ?? null;
                $user->save();
    
                Auth::login($user);
            }
        }

        return $next($request);
    }

    function XORCipher($data, $key = 'rosvuz2021sdo', $encode = true) {
        $dataLen = strlen($data);
        $keyLen = strlen($key);
        $output = $data;
        if ($encode == false) {
            $data = base64_decode($data);
            $dataLen = strlen($data);
        }
 
        for ($i = 0; $i < $dataLen; ++$i) {
            $output[$i] = $data[$i] ^ $key[$i % $keyLen];
        }
        if ($encode) {
            return base64_encode($output);
        }
        else {
            return substr($output, 0, $dataLen);
        } 
    }  
    
    // $out = XORCipher('test@mail.ru', 'rosvuz2021sdo', true);
    // echo $out;

    private function createUser($email, $userData) : User
    {
        $pwd = bin2hex(openssl_random_pseudo_bytes(4));

        $birth = $userData['birth'] == "" ? null : $userData['birth'];

        $user = new User;
        $user->email = $email;
        $user->password = Hash::make($pwd);
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
