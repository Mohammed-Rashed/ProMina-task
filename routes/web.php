<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/upload-picture', [App\Http\Controllers\AlbumController::class, 'upload_picture'])->name('upload-picture');
Route::post('/delete-picture', [App\Http\Controllers\AlbumController::class, 'delete_picture'])->name('delete-picture');


Route::resource('albums', App\Http\Controllers\AlbumController::class);
Auth::routes();
