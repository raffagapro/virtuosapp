<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

//testing route
Route::resource('test', App\Http\Controllers\MateriaController::class);
Route::resource('test2', App\Http\Controllers\ClaseController::class);

Route::get('/', function () {
    return view('auth.login');
})->middleware('user');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['GuestRoleRedirect'])->group(function (){
    Route::get('/guest', [App\Http\Controllers\GuestController::class, 'index'])->name('guest');
});

Route::middleware(['AdminRoleRedirect'])->group(function (){
    Route::get('/admin', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin');
    Route::get('/estudiantes', [App\Http\Controllers\Admin\StudentListController::class, 'index'])->name('studentList');
    Route::get('/materias', [App\Http\Controllers\Admin\MateriaController::class, 'index'])->name('subjects');

});

Route::middleware(['TeacherRoleRedirect'])->group(function (){
    Route::get('/maestro', [App\Http\Controllers\TeacherController::class, 'index'])->name('teacher');
});