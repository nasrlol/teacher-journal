<?php

use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubGroupController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes (public)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Public pages
Route::get('/faq', function () {
    return view('pages.faq');
})->name('faq');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:5000',
    ]);

    // Send email
    try {
        Mail::raw(
            "New contact message from {$validated['name']} ({$validated['email']})\n\n" .
            "Subject: {$validated['subject']}\n\n" .
            "Message:\n{$validated['message']}",
            function ($mail) use ($validated) {
                $mail->to('abdellah.el.morabit@student.ehb.be')
                    ->subject('Contact Form: ' . $validated['subject']);
            }
        );
    } catch (Exception $e) {
        Log::error('Failed to send contact email: ' . $e->getMessage());
    }

    return redirect()->route('contact')->with('success', 'Thank you for your message! We will get back to you soon.');
})->name('contact.send');

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

    Route::get('/app', function () {
        return view('app');
    })->name('app');
});
