<?php

use App\Http\Controllers\Admin\AdminCommentsController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminIdeasController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\NotebookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'ideas', 'as' => 'ideas.', 'middleware' => 'auth'], function () {
    Route::post('', [IdeaController::class, 'store'])->name('store');
    Route::delete('{idea}', [IdeaController::class, 'destroy'])->name('destroy');
    Route::get('{idea}/edit', [IdeaController::class, 'edit'])->name('edit');
    Route::put('{idea}', [IdeaController::class, 'update'])->name('update');
    Route::post('{idea}/like', [IdeaController::class, 'like'])->name('like');

    Route::get('{idea}', [IdeaController::class, 'show'])->name('show')->withoutMiddleware('auth');
});

Route::group(['prefix' => 'ideas/{idea}/comments', 'as' => 'ideas.comments.', 'middleware' => 'auth'], function () {
    Route::post('', [CommentController::class, 'store'])->name('store');
    Route::delete('/{comment}', [CommentController::class, 'destroy'])->middleware('can:admin')->name('destroy');
});

Route::group(['prefix' => 'notebooks', 'as' => 'notebooks.', 'middleware' => 'auth'], function () {
    Route::get('/', [NotebookController::class, 'index'])->withoutMiddleware('auth')->name('index');
    Route::get('create', [NotebookController::class, 'create'])->name('create');
});

Route::get('/profile', [UserController::class, 'profile'])->middleware('auth')->name('profile');

Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => 'auth'], function () {
    Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('{user}', [UserController::class, 'update'])->name('update');
    Route::post('{user}/follow', [UserController::class, 'follow'])->name('follow');
    Route::post('{user}/unfollow', [UserController::class, 'unfollow'])->name('unfollow');

    Route::get('{user}', [UserController::class, 'show'])->name('show')->withoutMiddleware('auth');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'can:admin']], function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::get('/ideas', [AdminIdeasController::class, 'index'])->name('ideas');
    Route::get('/comments', [AdminCommentsController::class, 'index'])->name('comments');
});

Route::get('/language/{locale}', function (string $locale) {
    session()->put('locale', $locale);
    return back();
})->name('change_language');

Route::get('/terms', fn () => view('terms'))->name('terms');
Route::get('/feed', FeedController::class)->middleware('auth')->name('feed');

