<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Teacher;

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
            'newsLessons' => Lesson::with(['group', 'teacher'])
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get(),
        ]);
    }
}

