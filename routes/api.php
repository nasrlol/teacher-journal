<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SubGroupController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ActivitiesController;

Route::get('teachers', [TeacherController::class, 'index']);
Route::post('teachers', [TeacherController::class, 'store']);
Route::get('teachers/{teacher}', [TeacherController::class, 'show']);
Route::put('teachers/{teacher}', [TeacherController::class, 'update']);
Route::delete('teachers/{teacher}', [TeacherController::class, 'destroy']);

Route::get('groups', [GroupController::class, 'index']);
Route::post('groups', [GroupController::class, 'store']);
Route::get('groups/{group}', [GroupController::class, 'show']);
Route::put('groups/{group}', [GroupController::class, 'update']);
Route::delete('groups/{group}', [GroupController::class, 'destroy']);
Route::get('groups/{group}/students', [GroupController::class, 'students']);
Route::get('groups/{group}/lessons', [GroupController::class, 'lessons']);

Route::get('sub-groups', [SubGroupController::class, 'index']);
Route::post('sub-groups', [SubGroupController::class, 'store']);
Route::get('sub-groups/{subGroup}', [SubGroupController::class, 'show']);
Route::put('sub-groups/{subGroup}', [SubGroupController::class, 'update']);
Route::delete('sub-groups/{subGroup}', [SubGroupController::class, 'destroy']);
Route::get('sub-groups/{subGroup}/students', [SubGroupController::class, 'students']);

Route::get('students', [StudentController::class, 'index']);
Route::post('students', [StudentController::class, 'store']);
Route::get('students/{student}', [StudentController::class, 'show']);
Route::put('students/{student}', [StudentController::class, 'update']);
Route::delete('students/{student}', [StudentController::class, 'destroy']);
Route::post('students/{student}/add-points', [StudentController::class, 'addPoints']);

Route::get('lessons', [LessonController::class, 'index']);
Route::post('lessons', [LessonController::class, 'store']);
Route::get('lessons/{lesson}', [LessonController::class, 'show']);
Route::put('lessons/{lesson}', [LessonController::class, 'update']);
Route::delete('lessons/{lesson}', [LessonController::class, 'destroy']);
Route::post('lessons/{lesson}/attach-students', [LessonController::class, 'attachStudents']);
Route::post('lessons/{lesson}/record-attendance', [LessonController::class, 'recordAttendance']);
Route::get('lessons/{lesson}/students', [LessonController::class, 'students']);

Route::get('activities', [ActivitiesController::class, 'index']);
Route::post('activities', [ActivitiesController::class, 'store']);
Route::get('activities/{activity}', [ActivitiesController::class, 'show']);
Route::put('activities/{activity}', [ActivitiesController::class, 'update']);
Route::delete('activities/{activity}', [ActivitiesController::class, 'destroy']);
Route::post('activities/{activity}/attach-students', [ActivitiesController::class, 'attachStudents']);
Route::post('activities/{activity}/record-score', [ActivitiesController::class, 'recordScore']);
Route::get('activities/{activity}/students', [ActivitiesController::class, 'students']);
