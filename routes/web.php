<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

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

Route::get('/', [HomeController::class, 'index'])->name('homepage');

Volt::route('/login', "auth.login")->name("login");

Route::middleware('auth')->group(function () {
    Volt::route('/dashboard', "dashboard.overview")->name('dashboard.overview');
    Volt::route('/dashboard/posts', "dashboard.posts.index")->name('dashboard.posts');
    Volt::route('/dashboard/posts/edit/{id}', "dashboard.posts.edit")->name('dashboard.posts.edit');
    Volt::route('/dashboard/profile', "dashboard.overview")->name('dashboard.profile');
});

Route::get('/post/{by}/{param}', [PostController::class, 'show'])->name('post.show');
