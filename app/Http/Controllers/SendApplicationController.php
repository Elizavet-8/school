<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationMail;
use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Mail;

class SendApplicationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|max:255',
            'grade' => 'integer|min:1|nullable',
        ],
        [
            'name.required' => 'Пожалуйста, укажите ваше ФИО',
            'email.required' => 'Пожалуйста, укажите ваш электронный адрес',
            'email.email' => 'Пожалуйста, введите коректный электронный адрес',
            'phone.required' => 'Введите номер телефона',
            'email.unique' => 'Учетная запись с таким электронным адресом уже существует',
            'max' => 'Максимальная длина параметра 255 символов',
            'min' => 'Минимальное значение класса 1',
            'grade.integer' => 'Класс должен быть целым числом',
        ]);

        $data = array('name' => $request->get('name'), 'email' => $request->get('email'), 'phone' => $request->get('phone'), 'grade' => $request->get('grade'));
        Mail::to('dima.rosvuz@yandex.ru')->send(new ApplicationMail($data, 'Заявка на регистрацию'));

        /*Application::create([
            'name' => $request->get('name'),
            'place_of_work' => $request->get('place_of_work'),
            'city' => $request->get('city'),
            'email' => $request->get('email'),
            'status' => 'новая',
        ]);*/

        return view('application_sent');
    }
}
