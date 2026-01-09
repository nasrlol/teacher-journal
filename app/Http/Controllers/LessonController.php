<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Teacher;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LessonController extends Controller
{
    /**
     * Display a listing of lessons.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = Lesson::with(['teacher', 'group']);

        if ($request->has('teacher_id') && $request->teacher_id) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->has('group_id') && $request->group_id) {
            $query->where('group_id', $request->group_id);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('scheduled_at', $request->date);
        }

        $lessons = $query->orderBy('scheduled_at', 'desc')->get();

        if ($request->expectsJson()) {
            return response()->json($lessons);
        }

        $groups = Group::pluck('name', 'id');
        $teachers = Teacher::all()->mapWithKeys(function ($teacher) {
            return [$teacher->id => $teacher->name . ' ' . $teacher->last_name];
        });

        return view('lessons.index', compact('lessons', 'groups', 'teachers'));
    }

    /**
     * Show the form for creating a new lesson.
     */
    public function create(): View
    {
        $groups = Group::pluck('name', 'id');
        $teachers = Teacher::all()->mapWithKeys(function ($teacher) {
            return [$teacher->id => $teacher->name . ' ' . $teacher->last_name];
        });

        return view('lessons.create', compact('groups', 'teachers'));
    }

    /**
     * Store a newly created lesson.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'required|exists:teachers,id',
            'group_id' => 'required|exists:groups,id',
            'scheduled_at' => 'nullable|date',
            'duration_minutes' => 'nullable|integer|min:1',
        ]);

        $lesson = Lesson::create($validated);

        if ($request->expectsJson()) {
            return response()->json($lesson->load(['teacher', 'group']), 201);
        }

        return redirect()->route('lessons.index')->with('success', 'Lesson created successfully.');
    }

    /**
     * Display the specified lesson.
     */
    public function show(Request $request, Lesson $lesson): View|JsonResponse
    {
        $lesson->load(['teacher', 'group', 'students']);

        if ($request->expectsJson()) {
            return response()->json($lesson);
        }

        $availableStudents = Student::with('group')->get();
        return view('lessons.show', compact('lesson', 'availableStudents'));
    }

    /**
     * Show the form for editing the specified lesson.
     */
    public function edit(Lesson $lesson): View
    {
        $groups = Group::pluck('name', 'id');
        $teachers = Teacher::all()->mapWithKeys(function ($teacher) {
            return [$teacher->id => $teacher->name . ' ' . $teacher->last_name];
        });

        return view('lessons.edit', compact('lesson', 'groups', 'teachers'));
    }

    /**
     * Update the specified lesson.
     */
    public function update(Request $request, Lesson $lesson): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'topic' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'sometimes|required|exists:teachers,id',
            'group_id' => 'sometimes|required|exists:groups,id',
            'scheduled_at' => 'nullable|date',
            'duration_minutes' => 'nullable|integer|min:1',
        ]);

        $lesson->update($validated);

        if ($request->expectsJson()) {
            return response()->json($lesson->load(['teacher', 'group']));
        }

        return redirect()->route('lessons.index')->with('success', 'Lesson updated successfully.');
    }

    /**
     * Remove the specified lesson.
     */
    public function destroy(Request $request, Lesson $lesson): JsonResponse|RedirectResponse
    {
        $lesson->delete();

        if ($request->expectsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('lessons.index')->with('success', 'Lesson deleted successfully.');
    }

    /**
     * Attach students to a lesson.
     */
    public function attachStudents(Request $request, Lesson $lesson): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $lesson->students()->sync($validated['student_ids']);

        if ($request->expectsJson()) {
            return response()->json($lesson->load('students'));
        }

        return redirect()->back()->with('success', 'Students attached successfully.');
    }

    /**
     * Record attendance for a student in a lesson.
     */
    public function recordAttendance(Request $request, Lesson $lesson): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'attendance' => 'required|boolean',
            'score' => 'nullable|integer|min:0|max:100',
        ]);

        $lesson->students()->updateExistingPivot($validated['student_id'], [
            'attendance' => $validated['attendance'],
            'score' => $validated['score'] ?? null,
        ]);

        if ($request->expectsJson()) {
            return response()->json($lesson->load('students'));
        }

        return redirect()->back()->with('success', 'Attendance recorded successfully.');
    }

    /**
     * Get students for a lesson.
     */
    public function students(Lesson $lesson): JsonResponse
    {
        return response()->json($lesson->students);
    }
}
