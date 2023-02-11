<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobListController;
use App\Http\Controllers\admin\AdminController;

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
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //  After authentication , users are redirected to specific dashboards based on role(user or admin)
    //  admin will have both access to user site and admin dashboard
    Route::get('authenticate', [AuthController::class, 'authenticate']);

    // User dashboard
    Route::get('account', [JobListController::class, 'dashboard'])->name(
        'dashboard'
    );

    // Admin dashboard routes
    Route::group(
        ['prefix' => 'admin', 'middleware' => 'adminAuth'],
        function () {
            Route::get('dashboard', [
                AdminController::class,
                'dashboard',
            ])->name('admin#dashboard');

            Route::get('profile', [AdminController::class, 'profile'])->name(
                'admin#profile'
            );
        }
    );
});
