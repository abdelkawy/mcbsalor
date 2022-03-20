<?php

use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LearningObjectController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\SendEmailController;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\LearningObject;
use App\Models\Log;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', '/ar');

Route::group(['prefix' => '{language}'], function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::get('/dashboard', function () {
        $total = 0;
        $loginArrD = array();
        $loginArrC = array();
        $postArrD = array();
        $postArrC = array();
        $changeArrD = array();
        $changeArrC = array();
        $logins = DB::table('logs')
            ->select(DB::raw('count(*) as loginsCount, date(created_at) as loginsDate'))
            ->where('user_id', '=', auth()->id())
            ->where('action', '=', 'Login')
            ->where('created_at', 'like', date('Y-m').'%')
            ->groupBy('loginsDate')
            ->get();
        foreach ($logins as $login) {
            array_push($loginArrD,$login->loginsDate);
            array_push($loginArrC,$login->loginsCount);
            $total += $login->loginsCount;
        }

        $posts = DB::table('logs')
            ->select(DB::raw('count(*) as postsCount, date(created_at) as postsDate'))
            ->where('user_id', '=', auth()->id())
            ->where('action', '=', 'Add')
            ->where('created_at', 'like', date('Y-m').'%')
            ->groupBy('postsDate')
            ->get();
        foreach ($posts as $post) {
            array_push($postArrD,$post->postsDate);
            array_push($postArrC,$post->postsCount);
            $total += $post->postsCount;
        }
        $changes = DB::table('logs')
            ->select(DB::raw('count(*) as changesCount, date(created_at) as changesDate'))
            ->where('user_id', '=', auth()->id())
            ->whereIn('action', ['Delete', 'Update'])
            ->where('created_at', 'like', date('Y-m').'%')
            ->groupBy('changesDate')
            ->get();
        foreach ($changes as $change) {
            array_push($changeArrD,$change->changesDate);
            array_push($changeArrC,$change->changesCount);
            $total += $change->changesCount;
        }
        $loginArray = array();
        $postArray = array();
        $changeArray = array();
        for ($i = 1; $i <= 30; $i++) {
            $date = date('Y-m') . "-" . str_pad($i,2,'0',STR_PAD_LEFT);
            if (in_array($date, $loginArrD)) {
                $key = array_search($date, $loginArrD);
                array_push($loginArray, $loginArrC[$key]);
            }
            else array_push($loginArray, 0);

            if (in_array($date, $postArrD)) {
                $key = array_search($date, $postArrD);
                array_push($postArray, $postArrC[$key]);
            }
            else array_push($postArray, 0);

            if (in_array($date, $changeArrD)) {
                $key = array_search($date, $changeArrD);
                array_push($changeArray, $changeArrC[$key]);
            }
            else array_push($changeArray, 0);
        }
        //dd($changeArray);
        return view('dashboard', [
            'logins' => $loginArray,
            'posts' => $postArray,
            'changes' => $changeArray,
            'total' => $total
        ]);
    })->middleware('auth')->name('dashboard');

    Route::get('/courses', function () {
        if (auth()->id() && (auth()->user()->role === 'Editor' || auth()->user()->role === 'Admin')) {
            $courses = Course::all();
        } else
            $courses = Course::all()->where('is_publish', '=', 1);
        return view('courses', ['courses' => $courses]);
    })->name('courses');

    Route::get('/topics', function () {
        $course = Course::all()->where('id', '=', request('crsid'));
        foreach ($course as $courseData) {
            $data = [
                'course_code' => $courseData->course_code,
                'course_name' => $courseData->course_name,
                'course_summery' => $courseData->course_summery,
                'course_image' => $courseData->course_image,
                'expert' => $courseData->expert->name,
                'topics' => Topic::all()->where('course_id', '=', $courseData->id)
            ];
        }

        return view('topics', $data);
    })->name('topics');

    Route::get('/objects', function () {
        $topic = Topic::all()->where('id', '=', request('tid'));
        foreach ($topic as $topicData) {
            $data = [
                'topic_name' => $topicData->topic_name,
                'topic_summery' => $topicData->topic_summery,
                'course_id' => $topicData->course_id,
                'course_code' => $topicData->course->course_code,
                'objects' => LearningObject::all()->where('course_id', '=', $topicData->course_id)->where('topic_id', '=', $topicData->id)
            ];
        }

        return view('objects', $data);
    })->name('objects');

    // Manage categories
    Route::get('/manage/categories', function () {
        return view('manage.categories', [
            'categories' => CourseCategory::all()
        ]);
    })->middleware('editor')->name('manage_categories');
    Route::post('/manage/categories', [CourseCategoryController::class, 'store'])->middleware('editor')->name('manage_categories');
    Route::get('/manage/category_update', [CourseCategoryController::class, 'findCategory'])->middleware('editor')->name('category_update');
    Route::post('/manage/category_update', [CourseCategoryController::class, 'updateCategory'])->middleware('editor')->name('category_update');
    Route::get('/manage/category_delete', [CourseCategoryController::class, 'deleteCategory'])->middleware('editor')->name('category_delete');

    // Manage courses
    Route::get('/manage/courses', function () {
        if (auth()->user()->role === 'Editor' || auth()->user()->role === 'Admin') {
            $courses = Course::all();
        } elseif (request('catid'))
            $courses = Course::all()->where('course_sm_expert', '=', auth()->id())->where('category_id', '=', request('catid'));
        else
            $courses = Course::all()->where('course_sm_expert', '=', auth()->id());
        return view('manage.courses', [
            'courses' => $courses,
            'categories' => CourseCategory::all(),
            'users' => User::all()->whereIn('role', ['Editor', 'SME'])
        ]);
    })->middleware('auth')->name('manage_courses');
    Route::post('/manage/courses', [CourseController::class, 'store'])->middleware('auth')->name('manage_courses');
    Route::get('/manage/course_update', [CourseController::class, 'findCourse'])->middleware('auth')->name('course_update');
    Route::post('/manage/course_update', [CourseController::class, 'updateCourse'])->middleware('auth')->name('course_update');
    Route::get('/manage/course_delete', [CourseController::class, 'deleteCourse'])->middleware('auth')->name('course_delete');
    Route::get('/manage/course_publish', [CourseController::class, 'publishCourse'])->middleware('editor')->name('course_publish');

    // Manage Topics
    Route::get('/manage/topics', function () {
        $topics = Topic::all()->where('course_id', '=', request('crsid'));
        if (auth()->user()->role === 'Editor' || auth()->user()->role === 'Admin') {
            $courses = Course::all();
        } else
            $courses = Course::all()->where('course_sm_expert', '=', auth()->id());
        return view('manage.topics', [
            'topics' => $topics,
            'courses' => $courses
        ]);
    })->middleware('auth')->name('manage_topics');
    Route::post('/manage/topics', [TopicController::class, 'store'])->middleware('auth')->name('manage_topics');
    Route::get('/manage/topic_update', [TopicController::class, 'findTopic'])->middleware('auth')->name('topic_update');
    Route::post('/manage/topic_update', [TopicController::class, 'updateTopic'])->middleware('auth')->name('topic_update');
    Route::get('/manage/topic_delete', [TopicController::class, 'deleteTopic'])->middleware('auth')->name('topic_delete');

    // Manage Objects
    Route::get('/manage/objects', function () {
        $objects = LearningObject::all()->where('course_id', '=', request('crsid'))->where('topic_id', '=', request('tid'));
        return view('manage.objects', [
            'objects' => $objects,
            'topics' => Topic::all()->where('course_id', '=', request('crsid')),
            'courses' => Course::all()->where('course_sm_expert', '=', auth()->id())
        ]);
    })->middleware('auth')->name('manage_objects');
    Route::post('/manage/objects', [LearningObjectController::class, 'store'])->middleware('auth')->name('manage_objects');
    Route::get('/manage/object_update', [LearningObjectController::class, 'findObject'])->middleware('auth')->name('object_update');
    Route::post('/manage/object_update', [LearningObjectController::class, 'updateObject'])->middleware('auth')->name('object_update');
    Route::get('/manage/object_delete', [LearningObjectController::class, 'deleteObject'])->middleware('auth')->name('object_delete');

    //Route::get('send-email', [SendEmailController::class, 'index'])->name('send-email');

    require __DIR__ . '/auth.php';
});


