<?php

use App\Enums\TodoTag;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use Monolog\Handler\RotatingFileHandler;

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

Route::view('/', 'home');

Route::get('login', [LoginController::class, 'showForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showForm'])->name('register.form');
Route::post('register', [RegisterController::class, 'register'])->name('register');


Route::post('todos/multi-confirmed', [TodoController::class, 'multiConfirmed'])->name('multi-confirmed');
Route::post('todos/multi-un-confirmed', [TodoController::class, 'multiUnConfirmed'])->name('multi-un-confirmed');

Route::get('todos/{todo}/confirmed', [TodoController::class, 'confirmed'])->name('todos.confirmed');

Route::get('todos/{todo}/unconfirmed', [TodoController::class, 'unconfirmed'])->name('todos.unconfirmed');

Route::get('todos/{todo}/done', [TodoController::class, 'done'])->name('todos.done');

Route::resource('todos', TodoController::class);
