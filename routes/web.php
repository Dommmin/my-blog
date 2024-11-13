<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('posts/{post}', [PostController::class, 'show'])->name('post.show');
Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('comments/{comment}', [CommentController::class,'destroy'])->name('comments.destroy');

Route::middleware('auth')->prefix('/admin')->name('admin.')->group(function () {
    Route::get('/', HomeController::class)->name('home');
    Route::resource('posts', AdminPostController::class)->names([
        'index' => 'posts.index',
        'create' => 'posts.create',
        'store' => 'posts.store',
        'edit' => 'posts.edit',
        'update' => 'posts.update',
        'destroy' => 'posts.destroy',
    ]);
});

Route::middleware('auth')->post('/upload', UploadController::class)->name('upload');
