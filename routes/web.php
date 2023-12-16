<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudyplansController;
use App\Http\Controllers\UserController;
use App\Models\AcademicYear;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect('home');
    return view('welcome');
});

Auth::routes([
    'register' => false, // Routes of Registration
    'reset' => false,    // Routes of Password Reset
    'verify' => false,   // Routes of Email Verification
]);

Route::get('/home', function () {
    /** @var \App\Models\User */
    $user = auth()->user();

    if ($user->isAdmin()) {
        return redirect("/admin/users");
    }
    return redirect("/student/dashboard");
})
    ->middleware('auth')
    ->name('home');


Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/users/promote', [UserController::class, 'promoteGet']);
        Route::post('/users/promote', [UserController::class, 'promote']);
        Route::resource('/users', UserController::class);
        Route::resource('/courses', CourseController::class);
        Route::resource('/studyplans', StudyplansController::class);
        Route::get('/studyplans/{studyplan}/assign', [StudyplansController::class, 'assignGet']);
        Route::post('/studyplans/{studyplan}/assign', [StudyplansController::class, 'assignPost']);
        Route::get('/studyplans/{studyplan}/unassign', [StudyplansController::class, 'assigned']);
        Route::post('/studyplans/{studyplan}/unassign', [StudyplansController::class, 'assignRemove']);
        Route::get('/studyplans/{studyplan}/view', [StudyplansController::class, 'view']);
        Route::resource('/academicyears', AcademicYearController::class);
        Route::get('/studyplans/{studyplan}/view/list', [StudyplansController::class, 'list']);
        Route::post('/studyplans/{studyplan}/view/list', [StudyplansController::class, 'listPost']);
        Route::get('/studyplans/{studyplan}/assignStudent', [StudyplansController::class, 'assignStudentGet']);
        Route::post('/studyplans/{studyplan}/assignStudent', [StudyplansController::class, 'assignStudentPost']);
        Route::delete('/users/{user}/destroyPlan', [UserController::class, 'destroyPlan']);
        Route::delete('/studyplans/{studyplan}/courses/{course}', [StudyplansController::class, 'courseRemove']);
        Route::get('/logs', [LogController::class, 'index']);
        Route::get('/users/{user}/view', [UserController::class, 'view']);
        //Route::post('/users/promote', [UserController::class, 'promote']);
    });
Route::prefix('student')
    ->middleware('auth')
    ->group(function () {
        Route::get('/index', [StudentController::class, 'index']);
        Route::get('/dashboard', [StudentController::class, 'dashboard']);
        Route::post('/index/submit', [StudentController::class, 'submit']);
    });
