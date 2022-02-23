<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';


Route::resource('section', App\Http\Controllers\SectionController::class);

Route::resource('section-activity', App\Http\Controllers\SectionActivityController::class);

Route::resource('round', App\Http\Controllers\RoundController::class);

Route::resource('round-activity', App\Http\Controllers\RoundActivityController::class);

Route::put('section/{section_id}/removeAdmin', [ App\Http\Controllers\SectionController::class, 'removeAdmin'])->name('section/remove-admin');
Route::put('section/{section_id}/addAdmins', [ App\Http\Controllers\SectionController::class, 'addAdmins'])->name('section/add-admins');

Route::put('section/{section_id}/removePupil', [ App\Http\Controllers\SectionController::class, 'removePupil'])->name('section/remove-pupil');
Route::put('section/{section_id}/addPupils', [ App\Http\Controllers\SectionController::class, 'addPupils'])->name('section/add-pupils');