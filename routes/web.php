<?php

use App\Http\Controllers\HomeController;
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

Route::get("/search", [HomeController::class, 'search'])->name('search');

Route::get("/about", [HomeController::class, 'about'])->name('about');

Route::get("/tag", [HomeController::class, 'tag'])->name('tag');


Volt::route('/login', "auth.login")->name("login");

Route::middleware('auth')->group(function () {
    Volt::route('/dashboard', "dashboard.overview")->name('dashboard.overview');
    Volt::route('/dashboard/posts', "dashboard.posts.index")->name('dashboard.posts');
    Volt::route('/dashboard/posts/edit/{id}', "dashboard.posts.edit")->name('dashboard.posts.edit');
    Volt::route('/dashboard/posts/create', "dashboard.posts.create")->name('dashboard.posts.create');
    Volt::route('/dashboard/profile', "dashboard.profile.index")->name('dashboard.profile');
    Volt::route('/dashboard/profile/password', "dashboard.profile.password")->name('dashboard.profile.password');
});

Route::get('/tag/{tag}', [HomeController::class, 'getPostByTag'])->name('tag.post');
Route::get('/post/{by}/{param}', [HomeController::class, 'showPost'])->name('post.show');
