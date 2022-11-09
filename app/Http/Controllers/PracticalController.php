<?php

namespace App\Http\Controllers;

use App\Models\Correct;
use App\Models\Practical;
use App\Models\Section;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PracticalController extends Controller
{

    public function practicals(Theme $theme)
    {
        return view('admin.theme.practical.practicalList', [
            'theme' => $theme
        ]);
    }

    public function toPractical(Theme $theme)
    {
        $sections = Section::all();

        return view('admin.theme.practical.practicalCreate', [
            'theme' => $theme,
            'sections' => $sections
        ]);
    }

    public function practical(Request $request)
    {
        $validator = $request->validate([
            'title' => 'required|max:255',
            'purpose' => 'required',
            'task' => 'required',
            'howtosend' => 'required',
            'recommendations' => 'required',
            'criteria' => 'required',
            'file' => 'max:10000|mimes:mp4,doc,pdf,docx,zip',
            'image' => 'max:10000|mimes:jpg,jpeg,png,gif,bmp',
            'correct' => 'required',
            'correct_file' => 'max:10000|mimes:mp4,doc,pdf,docx,zip',
        ],
            [
                'required' => 'Поле должно быть заполено!',
                'max' => 'Максимальная длина параметра 255 символов!',
                'file.max' => 'Максимальный вес 10000 символов!',
                'file.mimes' => 'Файл должен быть в формате mp4,doc,pdf,docx,zip!',
                'image.mimes' => 'Файл должен быть в формате jpg,jpeg,png,gif,bmp!',
                'correct_file.mimes' => 'Файл должен быть в формате mp4,doc,pdf,docx,zip!',
                'correct_file.max' => 'Максимальный вес 10000 символов!',
                'correct.required' => 'Поле с правильным решением должно быть заполено!',
            ]);

        $practical = new Practical;
        $practical->user()->associate($request->user());;
        $practical->theme_id = $request->get('theme_id');
        $practical->section_id = $request->get('section_id');
        $practical->title = $request->get('title');
        $practical->purpose = $request->get('purpose');
        $practical->task = $request->get('task');
        $practical->link = $request->get('link');
        $practical->image = $request->get('image');
        $practical->howtosend = $request->get('howtosend');
        $practical->recommendations = $request->get('recommendations');
        $practical->criteria = $request->get('criteria');
        $practical->correct = $request->get('correct');
        $practical->status = $request->get('status');

        if ($request->hasFile('file')) {
            $filename = $request->file->getClientOriginalName();
            $request->file->storeAs('files/practicals/' , $filename, 'public');
            $practical['file'] = "/storage/files/practicals/"  . $filename;
        } else {
            $practical->save();
        }

        if ($request->hasFile('image')) {
            $filename = Str::uuid().'.jpg';
            $request->image->storeAs('images/practicals/' , $filename, 'public');
            $practical['image'] = "/storage/images/practicals/" . $filename;
        } else {
            $practical->save();
        }

        if ($request->hasFile('correct_file')) {
            $filename = $request->correct_file->getClientOriginalName();
            $request->correct_file->storeAs('files/practicals/' , $filename, 'public');
            $practical['correct_file'] = "/storage/files/practicals/"  . $filename;
        } else {
            $practical->save();
        }

        $practical->save();

        return redirect()
            ->route('theme.practicals', $request->get('theme_id'))->with('success', 'Практическая добавлена');
    }

    public function toeditPractical(Theme $theme, Practical $practical)
    {
        $sections = Section::all();

        return view('admin.theme.practical.practicalEdit', [
            'theme' => $theme,
            'sections' => $sections,
            'practical' => $practical,
        ]);
    }

    public function editPractical(Request $request, Practical $practical)
    {
        $validator = $request->validate([
            'title' => 'required|max:255',
            'purpose' => 'required',
            'task' => 'required',
            'howtosend' => 'required',
            'recommendations' => 'required',
            'criteria' => 'required',
            'file' => 'max:10000|mimes:mp4,doc,pdf,docx,zip',
            'image' => 'max:10000|mimes:jpg,jpeg,png,gif,bmp',
            'correct' => 'required',
            'correct_file' => 'max:10000|mimes:mp4,doc,pdf,docx,zip',
        ],
            [
                'required' => 'Поле должно быть заполено!',
                'max' => 'Максимальная длина параметра 255 символов!',
                'file.max' => 'Максимальный вес 10000 символов!',
                'file.mimes' => 'Файл должен быть в формате mp4,doc,pdf,docx,zip!',
                'image.mimes' => 'Файл должен быть в формате jpg,jpeg,png,gif,bmp!',
                'correct_file.mimes' => 'Файл должен быть в формате mp4,doc,pdf,docx,zip!',
                'correct_file.max' => 'Максимальный вес 10000 символов!',
                'correct.required' => 'Поле с правильным решением должно быть заполено!',
            ]);
        $practical->title = $request->title;
        $practical->purpose = $request->purpose;
        $practical->task = $request->task;
        $practical->howtosend = $request->howtosend;
        $practical->recommendations = $request->recommendations;
        $practical->criteria = $request->criteria;
        $practical->link = $request->link;
        $practical->image = $request->image;
        $practical->correct = $request->correct;
        $practical->status = $request->status;


        if ($request->hasFile('file')) {
            $filename = $request->file->getClientOriginalName();
            if (Storage::exists('public/storage/files/practicals/' . $request->practical_id)) {
                $files = Storage::allFiles('public/storage/files/practicals/' . $request->practical_id);
                Storage::delete($files);
            }
            $request->file->storeAs('files/practicals/' , $filename, 'public');
            $practical['file'] = "/storage/files/practicals/"  . $filename;
        }

        if ($request->hasFile('image')) {
            $filename = $request->image->getClientOriginalName();
            if (Storage::exists('public/storage/images/practicals/' . $request->practical_id)) {
                $files = Storage::allFiles('public/storage/images/practicals/' . $request->practical_id);
                Storage::delete($files);
            }
            $request->image->storeAs('images/practicals/' , $filename, 'public');
            $practical['image'] = "/storage/images/practicals/" . $filename;
        }

        if ($request->hasFile('correct_file')) {
            $filename = $request->correct_file->getClientOriginalName();
            if (Storage::exists('public/storage/files/practicals/' . $request->practical_id)) {
                $files = Storage::allFiles('public/storage/files/practicals/' . $request->practical_id);
                Storage::delete($files);
            }
            $request->file->storeAs('files/practicals/' , $filename, 'public');
            $practical['file'] = "/storage/files/practicals/"  . $filename;
        }

        $practical->save();

        return redirect()
            ->route('theme.practicals', $request->get('theme_id'))
            ->with('success', 'Практическая успешно сохранена');
    }

    public function practicalCorrectSend(Request $request, Practical $practical)
    {
        $practical->to_user_id = $request->to_user_id;
        $practical->save();

        return redirect()->back()->withSuccess('Решение отправлено!');
    }

    public function deletePractical(Practical $practical)
    {
        $practical->delete();

        return redirect()->back()->withSuccess('Практическая успешно удалена!');
    }

    public function practicalCorrect(Request $request)
    {
        $validator = $request->validate([
            'correct' => 'required',
        ],
            [
                'required' => 'Поле статус должно быть заполено!',
            ]);
        $correct = new Correct;
        $practical = Practical::find($request->get('practical_id'));
        //$correct->user()->associate($request->user());
        $correct->to_user_id = $request->get('to_user_id');
        $correct->body = $request->get('body');
        $correct->correct = $request->get('correct');
        $practical->corrects()->save($correct);

        return redirect()->back()->withSuccess('Отправлено!');
    }

    public function practicalCorrectDelete(Correct $correct)
    {
        $correct->delete();

        return redirect()->back()->withSuccess('Статус успешно удален!');
    }

//    public function practicalStatus(Request $request, Practical $practical)
//    {
//        $practical->status = $request->status;
//        dd($practical->status);
//        $practical->save();
//
//        return redirect()->back()->withSuccess('Статус обновлён!');
//    }

}
