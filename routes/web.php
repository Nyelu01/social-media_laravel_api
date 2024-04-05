<?php

use App\Http\Controllers\API\Posts\CommentController;
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

// Route::get('/', function () {
//     // return view('welcome');
//     return "hello nyeluuuu";
// });

// Route::resource('/comments', CommentController::class);
Route::prefix('comments')->group(function () {
    Route::get('', [CommentController::class, 'index'])->name('get.comments');
    Route::get('create', [CommentController::class, 'create'])->name('create.comments');
    Route::post('create', [CommentController::class, 'store'])->name('store.comments');
    Route::post('{id}', [CommentController::class, 'show'])->name('store.comments');
});
