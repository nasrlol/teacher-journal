<?php

use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubGroupController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home']);

// Auth routes (public)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Password reset routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Public pages
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');

// Protected routes
Route::middleware('auth.token')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('teachers', TeacherController::class);
    Route::resource('groups', GroupController::class);
    Route::resource('sub-groups', SubGroupController::class);
    Route::resource('students', StudentController::class);
    Route::resource('lessons', LessonController::class);
    Route::resource('activities', ActivitiesController::class);

    // Additional routes for nested resources
    Route::get('groups/{group}/students', [GroupController::class, 'students'])->name('groups.students');
    Route::get('groups/{group}/lessons', [GroupController::class, 'lessons'])->name('groups.lessons');

    Route::get('sub-groups/{subGroup}/students', [SubGroupController::class, 'students'])->name('sub-groups.students');
    Route::post('students/{student}/add-points', [StudentController::class, 'addPoints'])->name('students.add-points');

    Route::post('lessons/{lesson}/attach-students', [LessonController::class, 'attachStudents'])->name('lessons.attach-students');
    Route::post('lessons/{lesson}/record-attendance', [LessonController::class, 'recordAttendance'])->name('lessons.record-attendance');
    Route::get('lessons/{lesson}/students', [LessonController::class, 'students'])->name('lessons.students');

    Route::post('activities/{activity}/attach-students', [ActivitiesController::class, 'attachStudents'])->name('activities.attach-students');
    Route::post('activities/{activity}/record-score', [ActivitiesController::class, 'recordScore'])->name('activities.record-score');
    Route::get('activities/{activity}/students', [ActivitiesController::class, 'students'])->name('activities.students');

    Route::get('/app', [PageController::class, 'app'])->name('app');
});
