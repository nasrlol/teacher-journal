<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Group;
use App\Models\Student;
use App\Models\Lesson;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'teacherCount' => Teacher::count(),
            'groupCount' => Group::count(),
            'studentCount' => Student::count(),
            'lessonCount' => Lesson::count(),
            'recentLessons' => Lesson::with('group')
                ->orderBy('scheduled_at', 'desc')
                ->limit(5)
                ->get(),
            'topStudents' => Student::with('group')
                ->orderBy('points', 'desc')
                ->limit(5)
                ->get(),
        ]);
    }
}

