<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProjectController;
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

Route::middleware('auth')->group(function () {
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
    Route::get('/posted/projects/{user_id}', [MypageController::class, 'postedProjects'])->name('posted.projects');
    Route::get('/commented/projects/{user_id}', [MypageController::class, 'commentedProjects'])->name('commented.projects');
    Route::get('/applied/projects/{user_id}', [MypageController::class, 'appliedProjects'])->name('applied.projects');

    //==========================================================================================================
    // 案件関連
    //==========================================================================================================

    Route::get('/project/detail/{project_id}', [ProjectController::class, 'detail'])->name('project.detail');
    Route::get('/project/edit/{project_id}', [ProjectController::class, 'edit'])->name('project.edit');
    Route::post('/project/detail/{project_id}', [ProjectController::class, 'apply'])->name('apply');
});

require __DIR__.'/auth.php';
