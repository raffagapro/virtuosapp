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

Route::get('/', function () {
    return view('auth.login');
})->middleware('user');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['GuestRoleRedirect'])->group(function (){
    Route::get('/guest', [App\Http\Controllers\GuestController::class, 'index'])->name('guest');
});

Route::prefix('admin')->group(function(){
    Route::middleware(['AdminRoleRedirect'])->group(function (){
        Route::get('/index', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin');

        Route::resource('estudiantes', App\Http\Controllers\Admin\StudentListController::class);
        Route::put('estudiantes/indv/activate/{clase_id}', [App\Http\Controllers\Admin\StudentListController::class, 'activate'])->name('estudiantes.activate');
        Route::put('estudiantes/indv/deactivate/{clase_id}', [App\Http\Controllers\Admin\StudentListController::class, 'deactivate'])->name('estudiantes.deactivate');
        
        Route::resource('maestros', App\Http\Controllers\Admin\TeacherListController::class);
        Route::put('maestros/indv/activate/{clase_id}', [App\Http\Controllers\Admin\TeacherListController::class, 'activate'])->name('maestros.activate');
        Route::put('maestros/indv/deactivate/{clase_id}', [App\Http\Controllers\Admin\TeacherListController::class, 'deactivate'])->name('maestros.deactivate');
        
        Route::resource('materias', App\Http\Controllers\Admin\MateriaController::class);
        Route::post('materias/mGrabber', [App\Http\Controllers\Admin\MateriaController::class, 'materiaGrabber']);

        Route::resource('clase', App\Http\Controllers\Admin\ClaseController::class, ['except'=>['index']]);
        Route::get('/clase/indv/{materia_id}', [App\Http\Controllers\Admin\ClaseController::class, 'index'])->name('clase.index');
        Route::post('clase/indv/cGrabber', [App\Http\Controllers\Admin\ClaseController::class, 'claseGrabber']);
        Route::post('clase/indv/studentSearcher', [App\Http\Controllers\Admin\ClaseController::class, 'studentSearcher']);
        Route::get('clase/student/{claseID}/{studentID}', [App\Http\Controllers\Admin\ClaseController::class, 'addStudent'])->name('clase.addStudent');
        Route::get('clase/student/rm/{claseID}/{studentID}', [App\Http\Controllers\Admin\ClaseController::class, 'rmStudent'])->name('clase.rmStudent');
        Route::put('clase/indv/activate/{clase_id}', [App\Http\Controllers\Admin\ClaseController::class, 'activate'])->name('clase.activate');
        Route::put('clase/indv/deactivate/{clase_id}', [App\Http\Controllers\Admin\ClaseController::class, 'deactivate'])->name('clase.deactivate');
   
    });
});

Route::prefix('maestro')->group(function(){
    Route::middleware(['TeacherRoleRedirect'])->group(function (){
        Route::get('/index', [App\Http\Controllers\Teacher\TeacherController::class, 'index'])->name('teacher');
        Route::get('/materia', [App\Http\Controllers\Teacher\MateriaController::class, 'index'])->name('maestroMateria');
        Route::get('/clase/indv/{materia_id}', [App\Http\Controllers\Teacher\ClaseController::class, 'index'])->name('maestroClase.index');
    });
});

Route::prefix('estudiante')->group(function(){
    Route::middleware(['StudentRoleRedirect'])->group(function (){
        Route::get('/index', [App\Http\Controllers\Student\StudentController::class, 'index'])->name('student');
        Route::get('/materia', [App\Http\Controllers\Student\MateriaController::class, 'index'])->name('studentMateria');
        Route::get('/tarea', [App\Http\Controllers\Student\TareaController::class, 'index'])->name('tarea');
    });
});