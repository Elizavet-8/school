<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FilesController extends Controller
{
//    public function getPhoto(Request $request, $part, $path)
//    {
//        if (!Storage::exists(storage_path("app/public/images/" . $part . "/" . $path))) {
//            $myFile = public_path("images/default-avatar.jpg");
//            $headers = ['Content-Type: image/png'];
//
//            return response()->file($myFile, $headers);
//        }
//
//
//        $myFile = storage_path("app/public/images/" . $part . "/" . $path);
//        $headers = ['Content-Type: image/jpeg'];
//
//        return response()->file($myFile, $headers);
//    }
//
//    public function getFileComment(Request $request, $path)
//    {
//        if (!Storage::exists(storage_path("app/public/comment/files" . "/" . $path))) {
//            $myFile = public_path("images/default-avatar.jpg");
//            $headers = ['Content-Type: binary/octet-stream'];
//
//            return response()->file($myFile, $headers);
//        }
//
//
//        $myFile = storage_path("app/public/comment/files" . "/" . $path);
//        $headers = ['Content-Type: binary/octet-stream'];
//
//        return response()->file($myFile, $headers);
//    }
//
//    public function getFile(Request $request, $path)
//    {
//        if (!Storage::exists(storage_path("app/public/practical/files" . "/" . $path))) {
//            $myFile = public_path("images/default-avatar.jpg");
//            $headers = ['Content-Type: binary/octet-stream'];
//
//            return response()->file($myFile, $headers);
//        }
//
//
//        $myFile = storage_path("app/public/practical/files" . "/" . $path);
//        $headers = ['Content-Type: binary/octet-stream'];
//
//        return response()->file($myFile, $headers);
//    }
//
//    public function getImgPractical(Request $request, $path)
//    {
//        if (!Storage::exists(storage_path("app/public/practical" . "/" . $path))) {
//            $myFile = public_path("images/default-avatar.jpg");
//            $headers = ['Content-Type: binary/octet-stream'];
//
//            return response()->file($myFile, $headers);
//        }
//
//
//        $myFile = storage_path("app/public/practical" . "/" . $path);
//        $headers = ['Content-Type: binary/octet-stream'];
//
//        return response()->file($myFile, $headers);
//    }
//
//
//    public function getAvatar(Request $request, $user_id, $path)
//    {
//        if (!Storage::exists(storage_path("app/public/images/users/" . $user_id . "/" . $path))) {
//            $myFile = public_path("images/default-avatar.jpg");
//            $headers = ['Content-Type: image/png'];
//
//            return response()->file($myFile, $headers);
//        }
//
//
//        $myFile = storage_path("app/public/images/users/" . $user_id . "/" . $path);
//        $headers = ['Content-Type: image/jpeg'];
//
//        return response()->file($myFile, $headers);
//    }


    private function getImage($path)
    {
        Log::info("getImage");
        Log::info(print_r(storage_path($path), true));
        /* if (!Storage::exists(storage_path($path))) {
             $myFile = public_path("images/default-avatar.jpg");
             $headers = ['Content-Type: image/png'];

             return response()->file($myFile, $headers);
         }
 */
        $myFile = storage_path($path);
        $headers = ['Content-Type: image/jpeg'];

        return response()->file($myFile, $headers);
    }

    public function getUserAvatar(Request $request, $userId, $name)
    {
        return $this->getImage("app/public/images/users/$userId/$name");

    }

    public function getThemeFiles(Request $request, $themeId, $name)
    {
        return $this->getFile("app/public/files/theme/$themeId/$name");

    }

    public function getPracticalImg(Request $request, $name)
    {
        return $this->getImage("app/public/images/practicals/$name");
    }

    public function getCommentImg(Request $request, $name)
    {
        Log::info("getCommentImg");
        return $this->getImage("app/public/images/comments/$name");
    }

    public function getQuestionsImg(Request $request, $name)
    {
        return $this->getImage("app/public/images/questions/$name");
    }

    public function getCourseImg(Request $request, $themeId, $name)
    {
        return $this->getImage("app/public/images/courses/$themeId/$name");
    }


    private function getFile($path)
    {/*
        if (!Storage::exists(storage_path($path))) {
            return redirect()->back()->with('error', 'Файл не найден');
        }*/
        $myFile = storage_path($path);
        $headers = ['Content-Type: binary/octet-stream'];

        return response()->file($myFile, $headers);
    }

    public function getPracticalFile(Request $request, $name)
    {
        return $this->getFile("app/public/files/practicals/$name");
    }

    public function getCommentFile(Request $request, $name)
    {
        return $this->getFile("app/public/files/comments/$name");
    }
}
