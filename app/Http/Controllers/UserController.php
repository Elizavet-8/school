<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateUserProfileData(Request $request, User $user)
    {
        $request->validate(
            [
                'name' => 'required|max:255',
                'city' => 'max:255',
                'place_of_work' => 'max:255',
                'birth' => 'before:now|nullable',
            ],
            [
                'name.required' => 'Поле имя должно быть заполено!',
                'max' => 'Максимальная длина параметра 255 символов!',
                'before' => 'Дата рождения не может быть в будущем'
            ]
        );

        $user->name = $request->get('name');
        $user->city = $request->get('city');
        $user->birth = $request->get('birth');
        $user->sex = $request->get('sex');
        $user->save();

        return $user;
    }

    public function updateUserProfileImageUpload(Request $request, User $user)
    {
        $request->validate(
            [
                'image' => 'image|mimes:jpg,jpeg,png,gif,bmp'
            ],
            [
                'mimes' => 'Изображение должно быть в формате jpg,jpeg,png,gif,bmp'
            ]
        );

        $filename = $request->image->getClientOriginalName();
        if (Storage::exists('public/images/users/' . $user->id)) {
            $files = Storage::allFiles('public/images/users/' . $user->id);
            Storage::delete($files);
        }
        $request->image->storeAs('images/users/' . $user->id, $filename, 'public');
        $user->update(['img_url' => "/storage/images/users/" . $user->id . "/" . $filename]);

        return $user;
    }

    public function updateUserProfileImageDelete(User $user)
    {
        if (Storage::exists('public/images/users/' . $user->id)) {
            $files = Storage::allFiles('public/images/users/' . $user->id);
            Storage::delete($files);
        }

        $user->update(['img_url' => null]);
        return $user;
    }

    public  function updateUserPassword(Request $request, User $user)
    {
        $request->validate(
            [
                'old_password' => 'required|password',
                'new_password' => 'required',
                'new_confirm_password' => 'required|same:new_password'
            ],
            [
                'required' => 'Поле должно быть заполено!',
                'password' => 'Введен неверный пароль',
                'same' => 'Пароли не совпадают'
            ]
        );

        $user->password = Hash::make($request->new_password);
        $user->save();
    }

    public  function updateUserEmail(Request $request, User $user)
    {
        $request->validate(
            [
                'current_password' => 'required|password',
                'email' => ['email', 'max:255', 'required', Rule::unique('users')->ignore($user->id)],
            ],
            [
                'required' => 'Поле должно быть заполено!',
                'password' => 'Введен неверный пароль',
                'email.unique' => 'Пользователь с таким e-mail уже существует!',
                'email.email' => 'e-mail указан в неверном формате!',
                'max' => 'Максимальная длина параметра 255 символов!',
            ]
        );

        $user->email = $request->email;
        $user->save();
    }
}
