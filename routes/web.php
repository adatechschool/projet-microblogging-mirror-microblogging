<?php

use App\Http\Controllers\ProfileController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Models\Post, App\Models\User;
use App\Http\Controllers\PostController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $posts = Post::all();
    $users = User::all();
    $categories = Category::all();
        return view('dashboard',compact('posts') , compact('users') , compact('categories'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





require __DIR__.'/auth.php';


Route::get('/yourPage', function(){
    $posts = Post::all();
    $users = User::all();
    $categories = Category::all();
    return view('yourPage', compact('posts', 'users', 'categories'));
})->name('yourPage.view');


Route::get('/create-post', function () {
    $post = new Post();
    $post->title = 'Mon premier article';
    $post->content = 'Mon contenu';
    $post->save();
    return $post;
});

Route::post('/yourPage', [PostController::class, 'store'])->name('posts.store');

