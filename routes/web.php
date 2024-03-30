<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
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

Route::middleware('auth')->resource('order', OrderController::class);
Route::middleware('auth')->get('/order', function () {
    return Inertia::render('Order');
});
// Route::middleware('auth')->get('order/create',[OrderController::class,'create'])->name('order.create');
// Route::middleware('auth')->get('order/store',[OrderController::class,'store'])->name('order.store');

// Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::resource('item',ItemController::class);


Route::get('/posts', [PostController::class, 'index'])->name('post.index');
Route::get('post/create', [PostController::class, 'index'])->name('post.create');
Route::get('post/{post}', [PostController::class, 'show'])->name('post.show');
Route::get('post/{post}/edit',[PostController::class, 'edit'])->name('post.edit');
Route::patch('post/{post}',[PostController::class,'update'])->name('post.update');
Route::delete('post/{post}',[PostController::class,'destroy'])->name('post.destroy');
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
