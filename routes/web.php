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

Route::get('/resetClave/{userID}', [App\Http\Controllers\Admin\AdminController::class, 'resetPW'])->name('user.resetPW');

Route::prefix('admin')->group(function(){
    Route::middleware(['AdminRoleRedirect'])->group(function (){
        Route::get('/index', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin');
        Route::post('/profileUpload', [App\Http\Controllers\Teacher\HomeworkController::class, 'uploadProfile'])->name('admin.profile');
        Route::put('info/{userId}', [App\Http\Controllers\Admin\TeacherListController::class, 'update'])->name('admin.updateInfo');
        Route::put('pw/{userId}', [App\Http\Controllers\Admin\AdminController::class, 'updatePW'])->name('admin.updatePW');
        

        Route::resource('estudiantes', App\Http\Controllers\Admin\StudentListController::class);
        Route::put('estudiantes/indv/activate/{student_id}', [App\Http\Controllers\Admin\TeacherListController::class, 'activate'])->name('estudiantes.activate');
        Route::put('estudiantes/indv/deactivate/{student_id}', [App\Http\Controllers\Admin\TeacherListController::class, 'deactivate'])->name('estudiantes.deactivate');
        Route::post('estudiantes/indv/tutorSearcher', [App\Http\Controllers\Admin\StudentListController::class, 'tutorSearcher']);
        Route::post('estudiantes/indv/claseSearcher', [App\Http\Controllers\Admin\StudentListController::class, 'claseSearcher']);
        Route::get('estudiantes/tutor/{tutorID}/{studentID}/{tutorNUm}', [App\Http\Controllers\Admin\StudentListController::class, 'addTutor'])->name('estudiantes.addTutor');
        Route::get('estudiantes/tutor/rm/{tutorID}/{studentID}/{tutorNUm}', [App\Http\Controllers\Admin\StudentListController::class, 'rmTutor'])->name('estudiantes.rmTutor');

        Route::resource('maestros', App\Http\Controllers\Admin\TeacherListController::class);
        Route::put('maestros/indv/activate/{clase_id}', [App\Http\Controllers\Admin\TeacherListController::class, 'activate'])->name('maestros.activate');
        Route::put('maestros/indv/deactivate/{clase_id}', [App\Http\Controllers\Admin\TeacherListController::class, 'deactivate'])->name('maestros.deactivate');
        Route::get('maestros/clase/{claseID}/{teacherID}', [App\Http\Controllers\Admin\TeacherListController::class, 'addTeacher'])->name('maestros.addTeacher');
        Route::get('maestros/clase/rm/{claseID}/{teacherID}', [App\Http\Controllers\Admin\TeacherListController::class, 'rmTeacher'])->name('maestros.rmTeacher');

        Route::resource('tutores', App\Http\Controllers\Admin\TutorListController::class);
        Route::put('tutores/indv/activate/{tutoresID}', [App\Http\Controllers\Admin\TeacherListController::class, 'activate'])->name('tutores.activate');
        Route::put('tutores/indv/deactivate/{tutoresID}', [App\Http\Controllers\Admin\TeacherListController::class, 'deactivate'])->name('tutores.deactivate');
        Route::get('tutores/clase/{claseID}/{tutoresID}', [App\Http\Controllers\Admin\TutorListController::class, 'addTeacher'])->name('tutores.addTeacher');
        Route::get('tutores/clase/rm/{claseID}/{tutoresID}', [App\Http\Controllers\Admin\TutorListController::class, 'rmTeacher'])->name('tutores.rmTeacher');
        Route::get('tutores/student/{tutorID}/{studentID}', [App\Http\Controllers\Admin\TutorListController::class, 'addStudent'])->name('tutores.addStudent');
        Route::get('tutores/student/rm/{tutorID}/{studentID}', [App\Http\Controllers\Admin\TutorListController::class, 'rmStudent'])->name('tutores.rmStudent');
        
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

        Route::resource('coordinator', App\Http\Controllers\Admin\CoordinatorController::class);
        Route::prefix('coordinator')->group(function(){
            Route::put('activate/{coordID}', [App\Http\Controllers\Admin\TeacherListController::class, 'activate'])->name('coordinator.activate');
            Route::put('deactivate/{coordID}', [App\Http\Controllers\Admin\TeacherListController::class, 'deactivate'])->name('coordinator.deactivate');
            Route::post('teacherSearcher', [App\Http\Controllers\Admin\CoordinatorController::class, 'teacherSearcher']);
            Route::get('addTeacher/{coordID}/{teacherID}', [App\Http\Controllers\Admin\CoordinatorController::class, 'addTeacher'])->name('coordinator.addTeacher');
            Route::get('rmTeacher/{coordObjID}', [App\Http\Controllers\Admin\CoordinatorController::class, 'rmTeacher'])->name('coordinator.rmTeacher');
        });
        
        Route::resource('sa', App\Http\Controllers\Admin\SuperAdminController::class);
        Route::prefix('sa')->group(function(){
            Route::post('newRole', [App\Http\Controllers\Admin\SuperAdminController::class, 'newRole'])->name('sa.newRole');
            Route::delete('delRole/{roleId}', [App\Http\Controllers\Admin\SuperAdminController::class, 'destroyRole'])->name('sa.delRole');
            Route::put('updateRole/{roleId}', [App\Http\Controllers\Admin\SuperAdminController::class, 'updateRole'])->name('sa.updateRole');
            Route::post('rGrabber', [App\Http\Controllers\Admin\SuperAdminController::class, 'roleGrabber']);
            Route::get('test/loadImg', [App\Http\Controllers\Admin\SuperAdminController::class, 'testIndex'])->name('sa.test');
            Route::post('test/upload', [App\Http\Controllers\Admin\SuperAdminController::class, 'testUpload'])->name('sa.testFile');
        });

        Route::prefix('monitor')->group(function(){
            Route::get('teacher/{teacherID}', [App\Http\Controllers\Admin\AdminController::class, 'monitorIndex'])->name('admin.teacherMonitor');
            Route::post('chatGrabber', [App\Http\Controllers\Admin\ChatController::class, 'grabber']);
            Route::post('cGrabber', [App\Http\Controllers\Admin\ClaseController::class, 'claseGrabber']);
            Route::get('teacher/clase/{claseID}', [App\Http\Controllers\Admin\AdminController::class, 'claseIndex'])->name('admin.teacherClaseMonitor');
            Route::post('teacher/newHomework', [App\Http\Controllers\Teacher\HomeworkController::class, 'store'])->name('admin.teacherNewHomeworkMonitor');
            Route::delete('teacher/delHomework/{hwId}', [App\Http\Controllers\Teacher\HomeworkController::class, 'destroy'])->name('admin.teacherDelHomework');
            Route::post('hGrabber', [App\Http\Controllers\Teacher\HomeworkController::class, 'homeworkGrabber']);
            Route::put('teacher/updateHomework/{hwId}', [App\Http\Controllers\Teacher\HomeworkController::class, 'update'])->name('admin.teacherUpdateHomework');
            Route::get('teacher/tarea/{tareaID}', [App\Http\Controllers\Admin\AdminController::class, 'showHomework'])->name('admin.teacherMonitorTareaIndv');
            Route::post('teacher/uHomework', [App\Http\Controllers\Teacher\HomeworkController::class, 'uploadFile'])->name('admin.monitorTeacherUfile');
            Route::delete('teacher/delFile/{fileId}', [App\Http\Controllers\Teacher\HomeworkController::class, 'deleteFile'])->name('admin.monitorTeacherDfile');
            Route::post('sGrabber', [App\Http\Controllers\Teacher\HomeworkController::class, 'studentGrabber']);
            Route::post('teacher/newRetro', [App\Http\Controllers\Teacher\HomeworkController::class, 'newRetro'])->name('admin.monitorTeacherRetroStore');
            Route::post('teacher/updateRetro', [App\Http\Controllers\Teacher\HomeworkController::class, 'updateRetro'])->name('admin.monitorTeacherRetroUpdate');
            Route::post('teacher/zlink', [App\Http\Controllers\Admin\ClaseController::class, 'setZlink'])->name('admin.monitorSetZlink');

            Route::get('student/{studentID}', [App\Http\Controllers\Admin\AdminController::class, 'sMonitorIndex'])->name('admin.studentMonitor');
            Route::get('student/{claseID}/{studentID}', [App\Http\Controllers\Admin\AdminController::class, 'sClaseIndex'])->name('admin.studentMonitorClase');
            Route::get('mstudent/tarea/{tareaID}/{studentID}', [App\Http\Controllers\Admin\AdminController::class, 'sShowHomework'])->name('admin.studentMonitorTarea');
        });

    });
});

Route::prefix('coordinador')->group(function(){
    Route::middleware(['CoordinatorRoleRedirect'])->group(function (){
        Route::get('index', [App\Http\Controllers\Coordinator\CoordinatorController::class, 'index'])->name('coordinator');
        Route::put('pw/{userId}', [App\Http\Controllers\Admin\AdminController::class, 'updatePW'])->name('coordinatorDash.updatePW');
        Route::put('info/{userId}', [App\Http\Controllers\Admin\CoordinatorController::class, 'update'])->name('coordinatorDash.updateInfo');
        Route::post('profileUpload', [App\Http\Controllers\Teacher\HomeworkController::class, 'uploadProfile'])->name('coordinatorDash.profile');

        Route::get('monitor/{teacherID}', [App\Http\Controllers\Coordinator\CoordinatorController::class, 'monitorIndex'])->name('coordinatorDash.monitor');
        Route::post('monitor/cGrabber', [App\Http\Controllers\Admin\ClaseController::class, 'claseGrabber']);
        Route::post('monitor/zlink', [App\Http\Controllers\Admin\ClaseController::class, 'setZlink'])->name('monitor.setZlink');
        Route::post('monitor/chatGrabber', [App\Http\Controllers\Admin\ChatController::class, 'grabber']);
        Route::get('monitor/clase/{claseID}', [App\Http\Controllers\Coordinator\CoordinatorController::class, 'claseIndex'])->name('monitor.clase');
        Route::post('monitor/newHomework', [App\Http\Controllers\Teacher\HomeworkController::class, 'store'])->name('monitor.newHomework');
        Route::delete('monitor/delHomework/{hwId}', [App\Http\Controllers\Teacher\HomeworkController::class, 'destroy'])->name('monitor.delHomework');
        Route::post('monitor/hGrabber', [App\Http\Controllers\Teacher\HomeworkController::class, 'homeworkGrabber']);
        Route::put('monitor/updateHomework/{hwId}', [App\Http\Controllers\Teacher\HomeworkController::class, 'update'])->name('monitor.updateHomework');
        Route::get('monitor/tarea/{tareaID}', [App\Http\Controllers\Coordinator\CoordinatorController::class, 'showHomework'])->name('monitor.tarea');
        Route::post('monitor/uHomework', [App\Http\Controllers\Teacher\HomeworkController::class, 'uploadFile'])->name('monitor.ufile');
        Route::delete('monitor/delFile/{fileId}', [App\Http\Controllers\Teacher\HomeworkController::class, 'deleteFile'])->name('monitor.dfile');
        Route::post('monitor/sGrabber', [App\Http\Controllers\Teacher\HomeworkController::class, 'studentGrabber']);
        Route::post('monitor/newRetro', [App\Http\Controllers\Teacher\HomeworkController::class, 'newRetro'])->name('monitor.retroStore');
        Route::post('monitor/updateRetro', [App\Http\Controllers\Teacher\HomeworkController::class, 'updateRetro'])->name('monitor.retroUpdate');
    });
});

Route::prefix('maestro')->group(function(){
    Route::middleware(['TeacherRoleRedirect'])->group(function (){
        Route::get('/index', [App\Http\Controllers\Teacher\TeacherController::class, 'index'])->name('teacher');
        Route::resource('homework', App\Http\Controllers\Teacher\HomeworkController::class, ['except'=>['index', 'show']]);
        Route::get('/clase/{claseID}', [App\Http\Controllers\Teacher\HomeworkController::class, 'index'])->name('maestroDash.clase');
        Route::get('/tarea/{tareaID}', [App\Http\Controllers\Teacher\HomeworkController::class, 'show'])->name('maestroDash.tarea');
        Route::post('/tarea/newRetro', [App\Http\Controllers\Teacher\HomeworkController::class, 'newRetro'])->name('retro.store');
        Route::post('/tarea/updateRetro', [App\Http\Controllers\Teacher\HomeworkController::class, 'updateRetro'])->name('retro.update');
        Route::post('clase/hGrabber', [App\Http\Controllers\Teacher\HomeworkController::class, 'homeworkGrabber']);
        Route::post('clase/sGrabber', [App\Http\Controllers\Teacher\HomeworkController::class, 'studentGrabber']);
        Route::post('/uHomework', [App\Http\Controllers\Teacher\HomeworkController::class, 'uploadFile'])->name('maestroDash.ufile');
        Route::post('/profileUpload', [App\Http\Controllers\Teacher\HomeworkController::class, 'uploadProfile'])->name('maestroDash.profile');
        Route::delete('/delFile/{fileId}', [App\Http\Controllers\Teacher\HomeworkController::class, 'deleteFile'])->name('maestroDash.dfile');

        Route::post('cGrabber', [App\Http\Controllers\Admin\ClaseController::class, 'claseGrabber']);
        Route::post('zlink', [App\Http\Controllers\Admin\ClaseController::class, 'setZlink'])->name('clase.setZlink');
        Route::put('pw/{userId}', [App\Http\Controllers\Admin\AdminController::class, 'updatePW'])->name('maestro.updatePW');
        Route::put('info/{userId}', [App\Http\Controllers\Admin\TeacherListController::class, 'update'])->name('maestro.updateInfo');

        Route::post('studentSearcher', [App\Http\Controllers\Admin\ClaseController::class, 'studentSearcher']);
        Route::get('chat/{recieverID}', [App\Http\Controllers\Admin\ChatController::class, 'create'])->name('meastro.newChat');
        Route::post('chat', [App\Http\Controllers\Admin\ChatController::class, 'store'])->name('chatTeacher.store');
        Route::post('chatGrabber', [App\Http\Controllers\Admin\ChatController::class, 'grabber']);
    });
});

Route::prefix('estudiante')->group(function(){
    Route::middleware(['StudentRoleRedirect'])->group(function (){
        Route::get('/index', [App\Http\Controllers\Student\StudentController::class, 'index'])->name('student');
        Route::resource('stHomework', App\Http\Controllers\Student\HomeworkController::class, ['except'=>['index', 'show']]);
        Route::get('/clase/{claseID}', [App\Http\Controllers\Student\HomeworkController::class, 'index'])->name('studentDash.clase');
        Route::get('/tarea/{tareaID}', [App\Http\Controllers\Student\HomeworkController::class, 'show'])->name('studentDash.tarea');
        Route::post('/uHomework', [App\Http\Controllers\Student\HomeworkController::class, 'uploadFile'])->name('studentDash.ufile');
        Route::get('/homeworkDone/{homeworkId}/{studentId}', [App\Http\Controllers\Student\HomeworkController::class, 'markComplete'])->name('studentDash.done');

        Route::put('pw/{userId}', [App\Http\Controllers\Admin\AdminController::class, 'updatePW'])->name('student.updatePW');
        Route::post('/profileUpload', [App\Http\Controllers\Teacher\HomeworkController::class, 'uploadProfile'])->name('studentDash.profile');

        Route::post('chatGrabber', [App\Http\Controllers\Admin\ChatController::class, 'grabber']);
        Route::post('chat', [App\Http\Controllers\Admin\ChatController::class, 'store'])->name('chatStudent.store');
        Route::post('chatMarker', [App\Http\Controllers\Admin\ChatController::class, 'edit']);

    });
});