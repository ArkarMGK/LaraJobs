<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\JobListController;

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

Route::get('/create',[JobListController::class, 'create'])->name('createJob');

Route::post('/crateJob', [JobListController::class, 'store'])->name('storeJob');

Route::get('/ajax/filterTags', [AjaxController::class, 'index'])->name('filerTags');
