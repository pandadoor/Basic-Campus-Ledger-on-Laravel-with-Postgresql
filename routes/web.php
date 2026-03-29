<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\CourseController;

Route::get('/', [AdminController::class, 'index'])->name('admin.index');
Route::resource('students', StudentController::class);
Route::resource('programs', ProgramController::class)->except(['show']);
Route::resource('courses', CourseController::class)->except(['show']);
