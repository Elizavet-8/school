<?php

use App\Http\Controllers\Admin\Api\SchoolController as ApiSchoolController;
use App\Http\Controllers\Admin\Api\UserController as ApiUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\SendApplicationController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PracticalController;
use App\Http\Controllers\ExelController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\UserController as UserComponentController;
use App\Http\Controllers\TestController as UserTestController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Guest

Route::get("/test-test",function(){
/*   $courses = \App\Models\Course::query()->take(10)->get();
   foreach ($courses as $cours)
       echo ($cours->not_read_course_comments??"-")."<br>";

   echo "------------------<br>";*/
    $themes = \App\Models\Theme::query()
        ->with(["comments"])->get();
    foreach ($themes as $theme)
        if ($theme->comments()->count()>0)
        echo ($theme->not_read_comments??"-")."<br>";
});




// Route::get('/test-xor', function () {
//     //$data = "admin@admin.com";
//     $data = "\x12\x01\x0E\e\v4\x12\x01\x0E\e\vZ\x10\n\x0E";
//     $key = "secret";

//     $dataLen = strlen($data);
// 	$keyLen = strlen($key);
// 	$output = $data;

// 	for ($i = 0; $i < $dataLen; ++$i) {
// 		$output[$i] = $data[$i] ^ $key[$i % $keyLen];
// 	}

//     dd($output);
// });
Route::get('/storage/images/users/{user_id}/{name}',  [FilesController::class, 'getUserAvatar']);
Route::get('/storage/files/theme/{themeId}/{name}',  [FilesController::class, 'getThemeFiles']);
Route::get('/storage/images/practicals/{name}',  [FilesController::class, 'getPracticalImg']);
Route::get('/storage/images/questions/{name}',  [FilesController::class, 'getQuestionsImg']);
Route::get('/storage/files/practicals/{name}',  [FilesController::class, 'getPracticalFile']);
Route::get('/storage/images/comments/{name}',  [FilesController::class, 'getCommentImg']);
Route::get('/storage/files/comments/{name}',  [FilesController::class, 'getCommentFile']);
Route::get('/storage/images/courses/{themeId}/{name}',  [FilesController::class, 'getCourseImg']);

Route::get('/course/export', [CourseController::class, 'CourseExport'])->name('course.export');

Route::get('/sent', function () {
    return view('auth.passwords.sent');
})->name('passwordsSent');

Route::post('/send-application', SendApplicationController::class)->name('application.send.guest');
Route::get('/create-application', [GuestController::class, 'application'])->name('application.create.guest');

Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');

Route::group(['middleware' => ['online_school_redirect']], function () {
    Auth::routes(
        ['register' => false]
    );
});

// Auth
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/other/courses', [HomeController::class, 'other'])->name('other.courses');
Route::get('/search/grade', [HomeController::class, 'searchGrade'])->name('search.grade');
// Продакшн тесты
Route::get('/test/about/{test}', [UserTestController::class, 'testBefore'])->name('test.about');
Route::get('/test/{test}', [UserTestController::class, 'test'])->name('test'); // Продакшн версия
Route::get('/test/{test}/json', [UserTestController::class, 'testJson'])->name('test.json');
Route::get('/test/result/{attempt}', [UserTestController::class, 'testResult'])->name('test.result');
Route::post('/start-test/{test}', [UserTestController::class, 'startTest'])->name('start.test');
Route::post('/validatate-test-result/{attempt}', [UserTestController::class, 'validatateTestResult'])->name('validatate.test.result');

Route::get('/test/template', [HomeController::class, 'test'])->name('test.template'); // Версия для разработки
Route::get('/testshow', [HomeController::class, 'testShow'])->name('test.show');
Route::get('/settings', [HomeController::class, 'settings'])->name('settings');
Route::get('/course/{course}', [HomeController::class, 'course'])->name('course.show.user');
Route::get('/theme/{theme}/{section}/materials', [HomeController::class, 'materials'])->name('theme.materials');
Route::get('/theme/{theme}/{section}/presentations', [HomeController::class, 'presentations'])->name('theme.presentations');
Route::get('/theme/{theme}/{section}/videos', [HomeController::class, 'videos'])->name('theme.video');
Route::get('/theme/{theme}/{section}/tests', [HomeController::class, 'tests'])->name('theme.test');
Route::get('/theme/{theme}/menu', [HomeController::class, 'menu'])->name('theme.menu');

Route::post('/theme/comment/store', [CommentController::class, 'store'])->name('comment.add');
Route::post('/theme/{comment}/delete', [CommentController::class, 'delete'])->name('comment.delete');
Route::post('/theme/reply/store', [CommentController::class, 'reply'])->name('reply.add');


Route::get('/theme/{theme}/materials', [HomeController::class, 'allMaterials'])->name('all.theme.materials');
Route::get('/theme/{theme}/presentations', [HomeController::class, 'allPresentations'])->name('all.theme.presentations');
Route::get('/theme/{theme}}/videos', [HomeController::class, 'allVideos'])->name('all.theme.video');
Route::get('/theme/{theme}/tests', [HomeController::class, 'allTests'])->name('all.theme.test');

Route::get('/theme/{theme}/practicals', [HomeController::class, 'allPracticals'])->name('all.theme.practicals');
Route::get('theme/{theme}/practicals/{practical}', [HomeController::class, 'onePractical'])->name('theme.practical');
Route::post('theme/practicals/feedback', [CommentController::class, 'feedbackPractical'])->name('theme.practical.feedback');
Route::post('/practicals/comment/store', [CommentController::class, 'storePractical'])->name('practical.comment.add');
Route::post('/practicals/{comment}/delete', [CommentController::class, 'deletePractical'])->name('practical.comment.delete');
Route::post('/practicals/{reply}/delete', [CommentController::class, 'deleteReply'])->name('reply.comment.delete');
Route::post('/practicals/reply/store', [CommentController::class, 'replyPractical'])->name('practical.reply.add');


Route::patch('/user/profile/{user}', [UserComponentController::class, 'updateUserProfileData'])->name('user.profile');
Route::post('/user/image/upload/{user}', [UserComponentController::class, 'updateUserProfileImageUpload'])->name('user.image.upload');
Route::post('/user/image/delete/{user}', [UserComponentController::class, 'updateUserProfileImageDelete'])->name('user.image.delete');
Route::post('/user/password/update/{user}', [UserComponentController::class, 'updateUserPassword'])->name('user.password.update');
Route::post('/user/email/update/{user}', [UserComponentController::class, 'updateUserEmail'])->name('user.email.update');


// Сохранить результаты попытки
Route::post('/complete', [UserTestController::class, 'complete'])->name('complete');
// Admin
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin|teacher']], function () {
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home.admin');
    // Пользователи
    Route::get('user/{user}/courses', [UserController::class, 'courses'])->name('user.courses');
    Route::get('user/{user}/course/{course}/tests', [UserController::class, 'tests'])->name('user.course.tests');
    Route::get('user/{user}/test/{test}/attempts', [UserController::class, 'attempts'])->name('user.test.attempts');
    Route::resource('user', UserController::class);

    /*Route::get('application/accept/{application}', [ApplicationController::class, 'accept'])->name('application.accept');
    Route::get('application/deny/{application}', [ApplicationController::class, 'deny'])->name('application.deny');
    Route::get('application/postpone/{application}', [ApplicationController::class, 'postpone'])->name('application.postpone');
    Route::post('application/deny', [ApplicationController::class, 'sendDenyEmail'])->name('application.send.deny');
    Route::resource('application', ApplicationController::class);*/
    // Школы
    Route::resource('school', SchoolController::class);
    // Курсы
    Route::get('course/{course}/chapters', [CourseController::class, 'chapters'])->name('course.chapters');
    Route::get('course/{course}/chapters/create', [ChapterController::class, 'createOfCourse'])->name('course.chapters.create');
    Route::get('course/{course}/chapters/edit/{chapter}', [ChapterController::class, 'editOfCourse'])->name('course.chapters.edit');
    Route::resource('course', CourseController::class);
    // Главы // Модули
    Route::get('chapter/{chapter}/themes', [ChapterController::class, 'themes'])->name('chapter.themes');
    Route::get('chapter/{chapter}/themes/create', [ThemeController::class, 'createOfChapter'])->name('chapter.themes.create');
    Route::get('chapter/{chapter}/themes/edit/{theme}', [ThemeController::class, 'editOfChapter'])->name('chapter.themes.edit');
    // Route::get('chapter/{chapter}/tests', [ChapterController::class, 'tests'])->name('chapter.tests');
    // Route::get('chapter/{chapter}/tests/create', [TestController::class, 'createOfChapter'])->name('chapter.tests.create');
    // Route::get('chapter/{chapter}/tests/edit/{test}', [TestController::class, 'editOfChapter'])->name('chapter.tests.edit');
    // Route::get('chapter/{chapter}/files', [ChapterController::class, 'files'])->name('chapter.files');
    // Route::get('chapter/{chapter}/files/create', [FileController::class, 'createOfChapter'])->name('chapter.files.create');
    Route::resource('chapter', ChapterController::class);

    // Темы
    Route::get('theme/{theme}/tests', [ThemeController::class, 'tests'])->name('theme.tests');
    Route::get('theme/{theme}/tests/create', [TestController::class, 'createOfTheme'])->name('theme.tests.create');
    Route::get('theme/{theme}/tests/edit/{test}', [TestController::class, 'editOfTheme'])->name('theme.tests.edit');
    Route::get('theme/{theme}/files', [ThemeController::class, 'files'])->name('theme.files');
    Route::get('theme/{theme}/videos', [ThemeController::class, 'videos'])->name('theme.videos');
    Route::get('theme/{theme}/files/create', [FileController::class, 'createOfTheme'])->name('theme.files.create');
    Route::get('theme/{theme}/files/{file}/create', [FileController::class, 'editOfTheme'])->name('theme.files.edit');
    Route::resource('theme', ThemeController::class);
    // Практические
    Route::get('theme/{theme}/practicals', [PracticalController::class, 'practicals'])->name('theme.practicals');
    Route::get('theme/{theme}/practical/create', [PracticalController::class, 'toPractical'])->name('theme.practical.create');
    Route::post('practical', [PracticalController::class, 'practical'])->name('theme.practical.store');
    Route::get('theme/{theme}/practicals/{practical}/edit', [PracticalController::class, 'toeditPractical'])->name('theme.practical.edit');
    Route::post('theme/practicals/{practical}/edit', [PracticalController::class, 'editPractical'])->name('theme.practical.update');
    Route::post('practical/{practical}/delete', [PracticalController::class, 'deletePractical'])->name('practical.delete');
    Route::post('theme/{theme}/practical/{practical}/correct', [PracticalController::class, 'practicalCorrect'])->name('theme.practical.correct');
    Route::post('theme/practical/correct/{correct}', [PracticalController::class, 'practicalCorrectDelete'])->name('theme.practical.correct.delete');
    Route::post('theme/practical/{practical}/correct/send', [PracticalController::class, 'practicalCorrectSend'])->name('theme.practical.correct.send');
//    Route::post('theme/practical/{practical}/status', [PracticalController::class, 'practicalStatus'])->name('theme.practical.status');

    Route::get('theme/{theme}/comments', [CommentController::class, 'toStoreComment'])->name('theme.comments');
//    Route::get('theme/{theme}/comments', [CommentController::class, 'adminReply'])->name('theme.comments.reply');
    Route::get('theme/{theme}/{practical}/comments', [CommentController::class, 'toStorePractical'])->name('practical.comments');
//    //Комментарии админ
//    Route::get('theme/{theme}/comments', [CommentController::class, 'toStoreComment'])->name('theme.comments');
//    Route::get('theme/{theme}/comments', [CommentController::class, 'StoreComment'])->name('theme.comments.add');
//    Route::get('theme/{practical}/comments', [CommentController::class, 'toStorePractical'])->name('practical.comments');
    // Тесты
    Route::post('temp/image', [TestController::class, 'imageSave'])->name('temp.image');
    Route::post('temp/image/delete', [TestController::class, 'imageDelete'])->name('temp.image.delete');
    Route::get('test/{test}/results', [TestController::class, 'results'])->name('test.results');
    Route::get('test/{test}/{user}/attempts', [TestController::class, 'userAttempts'])->name('test.user.attempts');
    Route::resource('test', TestController::class);
    // Файлы
    Route::get('theme/{theme}/video/create', [FileController::class, 'toVideo'])->name('theme.video.create');
    Route::get('theme/{theme}/video/{file}/edit', [FileController::class, 'toVideoEdit'])->name('theme.video.edit');
    Route::put('theme/video/{file}/edit', [FileController::class, 'videoUpdate'])->name('theme.video.update');
    Route::post('video', [FileController::class, 'video'])->name('theme.video.store');
    Route::get('file/{file}/delete', [FileController::class, 'deleteFile'])->name('file.delete');
    Route::resource('file', FileController::class);

    Route::get('/calendar', function () {
        return view('admin.calendar');
     });

    // json
    Route::group(['prefix' => 'api'], function () {
        Route::resource('users', ApiUserController::class);
        Route::resource('schools', ApiSchoolController::class);
    });

});

Route::view("/", "landing");
Route::view("/programs", "programs");
Route::get('/subjects', [LandingController::class, 'subjects'])->name('subjects');
Route::get('/modules', [LandingController::class, 'modules'])->name('modules');
Route::post('/sign-up', [LandingController::class, 'signup'])->name('sign.up');
Route::post('/order-call', [LandingController::class, 'orderCall'])->name('order.call');

Route::view("/entrance", "entrance");

Route::get('/search/teachers', [CourseController::class, 'searchTeachers'])->name('search.teachers');
Route::get('/search/courses', [CourseController::class, 'searchCourses'])->name('search.courses');

//Route::get('course/export', [CourseController::class, 'CourseExport'])->name('course.export');


