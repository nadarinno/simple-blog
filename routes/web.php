<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('posts.index');
});


Route::get(
    '/posts-trash',
    [PostController::class, 'trash']
)->name('posts.trash');

Route::patch(
    '/posts/{id}/restore',
    [PostController::class, 'restore']
)->name('posts.restore');

Route::delete(
    '/posts/{id}/force-delete',
    [PostController::class, 'forceDelete']
)->name('posts.force-delete');

Route::resource('posts', PostController::class);