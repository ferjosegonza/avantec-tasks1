<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [TaskController::class, 'index'])->name('home');
Route::resource('tasks', App\Http\Controllers\TaskController::class)->middleware('auth');

Route::get('task', [TaskController::class, 'index'])->name('task.index')->middleware('auth');
//Route::post('task/{id}', [TaskController::class, 'registrar'])->name('task.registrar');
Route::post('task', [TaskController::class, 'registrar'])->name('task.registrar')->middleware('auth');
Route::get('task/eliminar/{id}', [TaskController::class, 'eliminar'])->name('task.eliminar')->middleware('auth');
Route::get('task/editar/{id}', [TaskController::class, 'editar'])->name('task.editar')->middleware('auth');
Route::post('task/actualizar', [TaskController::class, 'actualizar'])->name('task.actualizar')->middleware('auth');