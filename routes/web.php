<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
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

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');*/
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});


Route::group(['middleware' => 'auth'], function () {
    Route::group([
        'prefix' => 'admin',
        'middleware' => 'is_admin',
        'as' => 'admin.'
    ], function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('employees', \App\Http\Controllers\Admin\EmployeeController::class);
        Route::resource('teams', \App\Http\Controllers\Admin\TeamController::class);
    });
    Route::group([
        'middleware' => 'is_employee',
        'as' => 'employee.'
    ], function () {
        Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/teams/{id}', [App\Http\Controllers\TeamController::class, 'show'])->name('teams.show');

        Route::resource('requests', \App\Http\Controllers\RequestController::class)->except(['index', 'destroy']);

        Route::get('/requests/{request}/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('/requests/{request}/permissions/{permission}/update', [PermissionController::class, 'update'])->name('permissions.update');

        Route::get('/employees/{employee}', [\App\Http\Controllers\EmployeeController::class, 'show'])->name('employees.show');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });
});
require __DIR__ . '/auth.php';
