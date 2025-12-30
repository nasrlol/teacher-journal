<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LessonController extends Controller
{
    /**
     * Display a listing of lessons.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Lesson::with(['teacher', 'group']);

        if ($request->has('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->has('group_id')) {
            $query->where('group_id', $request->group_id);
        }

        if ($request->has('date')) {
            $query->whereDate('scheduled_at', $request->date);
        }

        $lessons = $query->orderBy('scheduled_at', 'desc')->get();
        return response()->json($lessons);
    }

    /**
     * Store a newly created lesson.
     */
    public function store(Request $request): JsonResponse
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

        return response()->json($lesson->load(['teacher', 'group']), 201);
    }

    /**
     * Display the specified lesson.
     */
    public function show(Lesson $lesson): JsonResponse
    {
        return response()->json($lesson->load(['teacher', 'group', 'students']));
    }

    /**
     * Update the specified lesson.
     */
    public function update(Request $request, Lesson $lesson): JsonResponse
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

        return response()->json($lesson->load(['teacher', 'group']));
    }

    /**
     * Remove the specified lesson.
     */
    public function destroy(Lesson $lesson): JsonResponse
    {
        $lesson->delete();

        return response()->json(null, 204);
    }

    /**
     * Attach students to a lesson.
     */
    public function attachStudents(Request $request, Lesson $lesson): JsonResponse
    {
        $validated = $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $lesson->students()->syncWithoutDetaching($validated['student_ids']);

        return response()->json($lesson->load('students'));
    }

    /**
     * Record attendance for a student in a lesson.
     */
    public function recordAttendance(Request $request, Lesson $lesson): JsonResponse
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

        return response()->json($lesson->load('students'));
    }

    /**
     * Get students for a lesson.
     */
    public function students(Lesson $lesson): JsonResponse
    {
        return response()->json($lesson->students);
    }
}
