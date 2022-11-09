<?php

namespace App\Http\Controllers;

use App\Events\CommetCreated;
use App\Events\CommetPractical;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\Practical;
use App\Models\Comment;
use App\Models\Feedback;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validator = $request->validate([
            'body' => 'required|max:1000',
            'file' => 'max:10000|mimes:doc,pdf,docx,zip',
            'image' => 'max:10000|mimes:jpg,jpeg,png,gif,bmp',
        ],
            [
                'body.required' => 'Поле с текстом должно быть заполено!',
                'max' => 'Максимальная длина параметра 1000 символов!',
                'file.max' => 'Максимальный вес 10000 символов!',
                'file.mimes' => 'Файл должен быть в формате doc,pdf,docx,zip!',
                'image.max' => 'Максимальный вес 10000 символов!',
                'image.mimes' => 'Картинка должена быть в формате jpg,jpeg,png,gif,bmpf!',
            ]);
        $comment = new Comment;
        $comment->body = $request->get('body');
        $comment->user()->associate($request->user());
        $theme = Theme::find($request->get('theme_id'));

        if ($request->hasFile('image')) {
            $filename = Str::uuid() . '.jpg';
            $request->image->storeAs('images/comments/', $filename, 'public');
            $comment['image'] = "/storage/images/comments/" . $filename;
        } else {
            $theme->comments()->save($comment);
        }

        if ($request->hasFile('file')) {
            $filename = $request->file->getClientOriginalName();
            $request->file->storeAs('files/comments/', $filename, 'public');
            $comment['file'] = "/storage/files/comments/" . $filename;
        } else {
            $theme->comments()->save($comment);
        }


        $theme->comments()->save($comment);


        return redirect()->back()->with('success', 'Комментарий добавлен');
    }

    public function delete(Comment $comment, Request $request)
    {
        $path = str_replace('/public', '', $comment->image);
//        dd($path);
        Storage::disk('public')->delete($path);

        $comment->delete();

        return redirect()->back()->withSuccess('Комментарий удален!');
    }

    public function reply(Request $request)
    {
        $validator = $request->validate([
            'body' => 'required|max:1000',
            'file' => 'max:10000|mimes:doc,pdf,docx,zip',
            'image' => 'max:10000|mimes:jpg,jpeg,png,gif,bmp',
        ],
            [
                'body.required' => 'Поле с текстом должно быть заполено!',
                'max' => 'Максимальная длина параметра 1000 символов!',
                'file.max' => 'Максимальный вес 10000 символов!',
                'file.mimes' => 'Файл должен быть в формате doc,pdf,docx,zip!',
                'image.max' => 'Максимальный вес 10000 символов!',
                'image.mimes' => 'Картинка должена быть в формате jpg,jpeg,png,gif,bmpf!',
            ]);
        $reply = new Comment();
        $reply->body = $request->get('body');
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $theme = Theme::find($request->get('theme_id'));


        if ($request->hasFile('image')) {
            $filename = Str::uuid() . '.jpg';
            $request->image->storeAs('images/comments/', $filename, 'public');
            $reply['image'] = "/storage/images/comments/" . $filename;
        } else {
            $theme->comments()->save($reply);
        }

        if ($request->hasFile('file')) {
            $filename = $request->file->getClientOriginalName();
            $request->file->storeAs('files/comments/', $filename, 'public');
            $reply['file'] = "/storage/files/comments/" . $filename;
        } else {
            $theme->comments()->save($reply);
        }

        $theme->comments()->save($reply);
        return redirect()->back()->with('success', 'Комментарий добавлен');
    }

    public function deleteReply(Comment $reply)
    {
        $path = str_replace('/public', '', $reply->image);
        Storage::disk('public')->delete($path);
        $reply->delete();

        return redirect()->back()->withSuccess('Комментарий удален!');
    }

    public function storePractical(Request $request)
    {
        $validator = $request->validate([
            'body' => 'required|max:1000',
            'file' => 'max:10000|mimes:mp4,doc,pdf,docx,zip',
            'image' => 'max:10000|mimes:jpg,jpeg,png,gif,bmp',
        ],
            [
                'body.required' => 'Поле с текстом должно быть заполено!',
                'max' => 'Максимальная длина параметра 1000 символов!',
                'file.max' => 'Максимальный вес 10000 символов!',
                'file.mimes' => 'Файл должен быть в формате mp4,doc,pdf,docx,zip!',
                'image.max' => 'Максимальный вес 10000 символов!',
                'image.mimes' => 'Картинка должена быть в формате jpg,jpeg,png,gif,bmpf!',
            ]);
        $comment = new Comment;
        $comment->body = $request->get('body');
        $comment->user()->associate($request->user());
        $practical = Practical::find($request->get('practical_id'));
        $comment->teacher_id = $request->teacher_id;

        if ($request->hasFile('image')) {
            $filename = Str::uuid().'.jpg';
            $request->image->storeAs('images/comments/' , $filename, 'public');
            $comment['image'] = "/storage/images/comments/" . $filename;
        } else {
            $practical->comments()->save($comment);
        }

        if ($request->hasFile('file')) {
            $filename = $request->file->getClientOriginalName();
            $request->file->storeAs('files/comments/' , $filename, 'public');
            $comment['file'] = "/storage/files/comments/"  . $filename;
        } else {
            $practical->comments()->save($comment);
        }

        $practical->comments()->save($comment);
        return redirect()->back()->with('success', 'Комментарий добавлен!');
    }

    public function deletePractical(Comment $comment)
    {
        $path = str_replace("/storage/images/comment", "public", $comment->image);

        Storage::delete($path);
        $comment->delete();

        return redirect()->back()->withSuccess('Комментарий удален!');
    }

    public function replyPractical(Request $request)
    {
        $validator = $request->validate([
            'body' => 'required|max:1000',
            'file' => 'max:10000|mimes:mp4,doc,pdf,docx,zip',
            'image' => 'max:10000|mimes:jpg,jpeg,png,gif,bmp',
        ],
            [
                'body.required' => 'Поле с текстом должно быть заполено!',
                'max' => 'Максимальная длина параметра 1000 символов!',
                'file.max' => 'Максимальный вес 10000 символов!',
                'file.mimes' => 'Файл должен быть в формате mp4,doc,pdf,docx,zip!',
                'image.max' => 'Максимальный вес 10000 символов!',
                'image.mimes' => 'Картинка должена быть в формате jpg,jpeg,png,gif,bmpf!',
            ]);
        $reply = new Comment();
        $reply->body = $request->get('body');
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $practical = Practical::find($request->get('practical_id'));

        if ($request->hasFile('image')) {
            $filename = Str::uuid() . '.jpg';
            $request->image->storeAs('images/comments/', $filename, 'public');
            $reply['image'] = "/storage/images/comments/" . $filename;
        } else {
            $practical->comments()->save($reply);
        }

        if ($request->hasFile('file')) {
            $filename = $request->file->getClientOriginalName();
            $request->file->storeAs('files/comments/', $filename, 'public');
            $reply['file'] = "/storage/files/comments/" . $filename;
        } else {
            $practical->comments()->save($reply);
        }
        $practical->comments()->save($reply);
        return redirect()->back()->with('success', 'Комментарий добавлен!');
    }


    //Админ

    public function toStoreComment(Request $request, Theme $theme)
    {
        event(new CommetCreated($theme->id));
        return view('admin.chapter.comments', [
            'theme' => $theme,
        ]);
    }

    public function toStorePractical(Request $request, Theme $theme, Practical $practical)
    {
        event(new CommetPractical($practical->id));
        return view('admin.theme.practical.practicalComments', [
            'practical' => $practical,
            'theme' => $theme,
        ]);
    }

    public function feedbackPractical(Request $request)
    {
        $validator = $request->validate([
            'body' => 'required',
        ],
            [
                'required' => 'Выберите оценку!',
            ]);


        $feedback = new Feedback;
        $feedback->body = $request->get('body');
        $feedback->user()->associate($request->user());
        $practical = Practical::find($request->get('practical_id'));
//        dd($feedback);
        $practical->feedbacks()->save($feedback);
        return redirect()->back()->withSuccess('Спасибо за ваш отзыв!');
    }

}
