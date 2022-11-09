<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\File;
use App\Models\Practical;
use App\Models\Section;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function createOfTheme(Theme $theme)
    {
        $sections = Section::all();

        return view('admin.file.create', [
            'theme' => $theme,
            'sections' => $sections
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'title' => 'required|max:255',
            'file' => 'required'//'required|mimes:pdf'
        ],
            [
                'title.required' => 'Поле название должно быть заполено!',
                'max' => 'Максимальная длина параметра 255 символов!',
                'file.required' => 'Пожалуйста, прикрепите файл!',
                //'mimes' => 'Изображение должно быть в формате pdf'
            ]);

        $filename = $request->file->getClientOriginalName();
        $request->file->storeAs('files/theme/' . $request->theme_id, $filename, 'public');

        $file = File::create([
            'title' => $request->title,
            'type' =>  $request->file->getClientOriginalExtension(),
            'url' => "/storage/files/theme/" . $request->theme_id . "/" . $filename,
            'theme_id' => $request->theme_id,
            'section_id' => $request->section_id
        ]);

        return redirect()
            ->route('theme.files', $request->get('theme_id'))
            ->with('success', 'Файл успешно добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    public function editOfTheme(Theme $theme, File $file)
    {
        $sections = Section::all();

        return view('admin.file.edit', [
            'theme' => $theme,
            'sections' => $sections,
            'file' => $file
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        $validator = $request->validate([
            'title' => 'required|max:255',
            //'file' => 'required'//'required|mimes:pdf'
        ],
            [
                'title.required' => 'Поле название должно быть заполено!',
                'max' => 'Максимальная длина параметра 255 символов!',
                //'file.required' => 'Пожалуйста, прикрепите файл!',
                //'mimes' => 'Изображение должно быть в формате pdf'
            ]);

        $file->title = $request->title;
        $file->theme_id = $request->theme_id;
        $file->section_id = $request->section_id;

        if ($request->hasFile('file')) {
            $filename = $request->file->getClientOriginalName();
            if (Storage::exists('public/files/theme/' . $request->theme_id)) {
                $files = Storage::allFiles('public/files/theme/' . $request->theme_id);
                Storage::delete($files);
            }
            $request->file->storeAs('files/theme/' . $request->theme_id, $filename, 'public');
            $file->url = "/storage/files/theme/" . $request->theme_id . "/" . $filename;
            $file->type =  $request->file->getClientOriginalExtension();
        }


        if ($file->url != "" && $request->file_name) {
            if (Storage::exists('public/files/theme/' . $request->theme_id)) {
                $files = Storage::allFiles('public/files/theme/' . $request->theme_id);
                Storage::move($files[0], 'public/files/theme/' . $request->theme_id . "/" . $request->file_name . "." . $file->type);
                $file->url = "/storage/files/theme/" . $request->theme_id . "/" . $request->file_name . "." . $file->type;
            }
        }

        $file->save();

        /*$filename = $request->file->getClientOriginalName();
        $request->file->storeAs('files/theme/' . $request->theme_id, $filename, 'public');

        $file = File::create([
            'title' => $request->title,
            'type' =>  $request->file->getClientOriginalExtension(),
            'url' => "/storage/files/theme/" . $request->theme_id . "/" . $filename,
            'theme_id' => $request->theme_id,
            'section_id' => $request->section_id
        ]);*/

        return redirect()
            ->route('theme.files', $request->get('theme_id'))
            ->with('success', 'Файл успешно сохранен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $path = str_replace("/storage", "public", $file->url);

        Storage::delete($path);

        $file->delete();

        return redirect()->back()->withSuccess('Файл успешно удален!');
    }

    public function toVideo(Theme $theme)
    {
        $sections = Section::all();

        return view('admin.file.video', [
            'theme' => $theme,
            'sections' => $sections
        ]);
    }

    public function toVideoEdit(Theme $theme, File $file)
    {
        $sections = Section::all();

        return view('admin.file.video_edit', [
            'theme' => $theme,
            'sections' => $sections,
            'file' => $file
        ]);
    }

    public function video(Request $request)
    {
        $validator = $request->validate([
            'title' => 'required|max:255',
            'file' => 'required|max:255'
        ],
            [
                'title.required' => 'Поле название должно быть заполено!',
                'max' => 'Максимальная длина параметра 255 символов!',
                'file.required' => 'Поле ссылки должно быть заполено!',
            ]);

        $url = str_replace('watch?v=', 'embed/', $request->file);

        $file = File::create([
            'title' => $request->title,
            'type' => 'video',
            'url' => $url,
            'theme_id' => $request->theme_id,
            'section_id' => $request->section_id
        ]);

        return redirect()
            ->route('theme.videos', $request->get('theme_id'))
            ->with('success', 'Видео успешно добавлено');
    }

    public function videoUpdate(Request $request, File $file)
    {
        $validator = $request->validate([
            'title' => 'required|max:255',
            'file' => 'required|max:255'
        ],
            [
                'title.required' => 'Поле название должно быть заполено!',
                'max' => 'Максимальная длина параметра 255 символов!',
                'file.required' => 'Поле ссылки должно быть заполено!',
            ]);

        $url = str_replace('watch?v=', 'embed/', $request->file);

        $file->title = $request->title;
        $file->url = $url;
        $file->theme_id = $request->theme_id;
        $file->section_id = $request->section_id;
        $file->save();

        return redirect()
            ->route('theme.videos', $request->get('theme_id'))
            ->with('success', 'Видео успешно сохранено');
    }

    public function videoApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url|max:255',
            'theme' => 'required|max:255',
            'module' => 'required|max:255',
            'section' => 'int|min:1|max:5|nullable'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Response::json([
                'error' => $error
            ], 422);
        }

        $chapters = Chapter::where('title', 'like', '%' . $request->module . '%')->get();

        if ($chapters->count() == 0) {
            return Response::json([
                'error' => 'module not found'
            ], 404);
        }

        if ($chapters->count() > 1) {
            return Response::json([
                'error' => 'found 2 or more modules with this title'
            ], 422);
        }

        $themes = Theme::where('title', 'like', '%' . $request->theme . '%')->where('chapter_id', $chapters[0]->id)->get();

        if ($themes->count() == 0) {
            return Response::json([
                'error' => 'theme not found'
            ], 404);
        }

        if ($themes->count() > 1) {
            return Response::json([
                'error' => 'found 2 or more themes with this title'
            ], 422);
        }

        $url = str_replace('watch?v=', 'embed/', $request->url);

        $videoArray = explode("/", $url);
        $videoArrayLast = end($videoArray);
        $videoId = explode("?", $videoArrayLast)[0];

        $videoExists = File::where('theme_id', $themes[0]->id)->where('section_id', $request->section ?? 1)->where('url', 'like', '%' . $videoId . '%')->first();

        $baseUrl = App::make('url')->to('/');

        if ($videoExists) {
            return Response::json([
                'url' => $baseUrl . "/theme/" . $themes[0]->id . "/" . ($request->section ?? 1) . "/videos"
            ], 200);
        }

        File::create([
            'title' => $request->theme,
            'type' => 'video',
            'url' => $url,
            'theme_id' => $themes[0]->id,
            'section_id' => $request->section ?? 1
        ]);

        return Response::json([
            'url' => $baseUrl . "/theme/" . $themes[0]->id . "/" . ($request->section ?? 1) . "/videos"
        ], 200);
    }

    public function deleteFile(File $file)
    {
        $path = str_replace("/storage", "public", $file->url);

        Storage::delete($path);

        $file->url = "";
        $file->save();

        return redirect()->back();
    }
}
