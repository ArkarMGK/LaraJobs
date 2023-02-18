<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobListController;
use App\Http\Controllers\admin\JobsController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\EmploymentTypeController;

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

Route::get('/', [JobListController::class, 'index'])->name('home');

// CREATE AND STORE
Route::get('/create', [JobListController::class, 'create'])->name('createJob');

Route::post('/createJob', [JobListController::class, 'store'])->name(
    'storeJob'
);

// EDIT AND UPDATE
Route::get('/create/{id}', [JobListController::class, 'edit'])->name('editJob');

Route::post('/update/{id}', [JobListController::class, 'update'])->name(
    'updateJob'
);

//
Route::get('/ajax/filterTags', [AjaxController::class, 'index'])->name(
    'filerTags'
);

Route::get('/admin', [AdminController::class, 'login'])
    ->name('admin#login')
    ->middleware('adminAuth');

Route::middleware([
    'auth:sanctum',
    // config('jetstream.auth_session'),
    // 'verified',
])->group(function () {
    //  After authentication , users are redirected to specific dashboards based on role(user or admin)
    //  admin will have both access to user site and admin dashboard
    Route::get('authenticate', [AuthController::class, 'authenticate']);

    // User dashboard
    Route::get('account', [JobListController::class, 'dashboard'])->name(
        'dashboard'
    );

    // User dashboard
    Route::get('history', [JobListController::class, 'history'])->name(
        'history'
    );

    // Admin dashboard routes
    Route::group(
        ['prefix' => 'admin', 'middleware' => 'adminAuth'],
        function () {
            Route::get('dashboard', [
                AdminController::class,
                'dashboard',
            ])->name('admin#dashboard');

            // admin account info
            Route::get('profile', [AdminController::class, 'profile'])->name(
                'admin#profile'
            );

            // update admin profile
            Route::post('update', [
                AdminController::class,
                'updateProfile',
            ])->name('admin#updateProfile');

            Route::post('password', [
                AdminController::class,
                'updatePassword',
            ])->name('admin#updatePassword');

            // employmentType CRUD
            Route::prefix('employment')->group(function () {
                Route::get('index', [
                    EmploymentTypeController::class,
                    'index',
                ])->name('admin#employmentType');

                Route::get('create', [
                    EmploymentTypeController::class,
                    'create',
                ])->name('admin#createEmployment');

                Route::post('create', [
                    EmploymentTypeController::class,
                    'store',
                ])->name('admin#storeEmployment');

                Route::delete('destroy/{employment}', [
                    EmploymentTypeController::class,
                    'destroy',
                ])->name('admin#deleteEmploymentType');

                Route::get('edit/{employment}', [
                    EmploymentTypeController::class,
                    'edit',
                ])->name('admin#editEmploymentType');

                Route::post('update/{employment}', [
                    EmploymentTypeController::class,
                    'update',
                ])->name('admin#updateEmploymentType');
            });

            // Joblist CRUD
            Route::prefix('job')->group(function () {
                Route::get('index', [JobsController::class, 'index'])->name(
                    'admin#jobList'
                );

                Route::get('oldJobs', [JobsController::class, 'oldJobs'])->name(
                    'admin#oldJobList'
                );

                Route::delete('destroy/{job}', [
                    JobListController::class,
                    'destroy',
                ])->name('admin#deleteJob');

                Route::post('hired/{job}', [
                    JobsController::class,
                    'hiredJob',
                ])->name('admin#hiredJob');

                Route::post('vacant/{job}', [
                    JobsController::class,
                    'vacantJob',
                ])->name('admin#vacantJob');

                Route::delete('destroy/{job}', [
                    JobsController::class,
                    'destroy',
                ])->name('admin#deleteJob');
            });

            // User CRUD
            Route::prefix('user')->group(function () {
                Route::get('index', [UserController::class, 'index'])->name(
                    'admin#userList'
                );

                Route::get('show/{user}', [
                    UserController::class,
                    'show',
                ])->name('admin#userInfo');

                Route::delete('delete/{user}', [
                    UserController::class,
                    'destroy',
                ])->name('admin#deleteUser');
            });
        }
    );
});
