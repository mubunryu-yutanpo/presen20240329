<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MessageController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//==========================================================================================================
// 案件一覧
//==========================================================================================================

Route::get('/projects', [ProjectController::class, 'list'])->name('list');

Route::middleware(['auth', 'verified'])->group(function () {
    //==========================================================================================================
    // プロフィール関連
    //==========================================================================================================

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //==========================================================================================================
    // マイページ関連
    //==========================================================================================================

    Route::get('/mypage', [MypageController::class, 'getMypage'])->name('mypage');
//    Route::get('/mypage', function () {
//        return Inertia::render('Profile/Mypage');
//    })->name('mypage');
    Route::get('/posted/projects/{user_id}', [MypageController::class, 'postedProjects'])->where('user_id', '[0-9]+')->name('posted.projects');
    Route::get('/commented/projects/{user_id}', [MypageController::class, 'commentedProjects'])->where('user_id', '[0-9]+')->name('commented.projects');
    Route::get('/applied/projects/{user_id}', [MypageController::class, 'appliedProjects'])->where('user_id', '[0-9]+')->name('applied.projects');

    //==========================================================================================================
    // 案件関連
    //==========================================================================================================

    Route::get('/project/detail/{project_id}', [ProjectController::class, 'detail'])->name('project.detail');

    Route::get('/project/create', [ProjectController::class, 'new'])->name('project.new');
    Route::post('/project/create', [ProjectController::class, 'addProject'])->where('project_id', '[0-9]+')->name('project.add');
    Route::get('/project/edit/{project_id}', [ProjectController::class, 'edit'])->where('project_id', '[0-9]+')->name('project.edit');
    Route::patch('/project/edit/{project_id}/update', [ProjectController::class, 'updateProject'])->where('project_id', '[0-9]+')->name('project.update');
    Route::post('/project/edit/{project_id}/delete', [ProjectController::class, 'deleteProject'])->where('project_id', '[0-9]+')->name('project.delete');
    Route::post('/project/detail/{project_id}', [ProjectController::class, 'apply'])->where('project_id', '[0-9]+')->name('apply');

    //==========================================================================================================
    // チャット・メッセージ関連
    //==========================================================================================================

    Route::get('/chat/list/{user_id}', [MessageController::class, 'chatList'])->where('user_id', '[0-9]+')->name('chat.list');
    Route::get('/chat/{chat_id}', [MessageController::class, 'chatDetail'])->where('chat_id', '[0-9]+')->name('chat.detail');
    Route::post('/chat/{chat_id}/{user1_id}/{user2_id}', [MessageController::class, 'addDirectMessage'])
        ->where('chat_id', '[0-9]+')
        ->where('user1_id', '[0-9]+')
        ->where('user2_id', '[0-9]+')
        ->name('dm.add');

    Route::post('/project/addMessage/{project_id}', [MessageController::class, 'addPublicMessage'])->where('project_id', '[0-9]+')->name('publick_message.add');

    Route::get('/notifications/{user_id}', [MessageController::class, 'notifications'])->where('user_id', '[0-9]+')->name('notifications');

});

require __DIR__.'/auth.php';
