<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of activities.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Activity::with(['teacher', 'group']);

        if ($request->has('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->has('group_id')) {
            $query->where('group_id', $request->group_id);
        }

        if ($request->has('date')) {
            $query->whereDate('date', $request->date);
        }

        $activities = $query->orderBy('date', 'desc')->get();
        return response()->json($activities);
    }

    /**
     * Store a newly created activity.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'teacher_id' => 'required|exists:teachers,id',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $activity = Activity::create($validated);

        return response()->json($activity->load(['teacher', 'group']), 201);
    }

    /**
     * Display the specified activity.
     */
    public function show(Activity $activity): JsonResponse
    {
        return response()->json($activity->load(['teacher', 'group', 'students']));
    }

    /**
     * Update the specified activity.
     */
    public function update(Request $request, Activity $activity): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'sometimes|required|date',
            'teacher_id' => 'sometimes|required|exists:teachers,id',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $activity->update($validated);

        return response()->json($activity->load(['teacher', 'group']));
    }

    /**
     * Remove the specified activity.
     */
    public function destroy(Activity $activity): JsonResponse
    {
        $activity->delete();

        return response()->json(null, 204);
    }

    /**
     * Attach students to an activity.
     */
    public function attachStudents(Request $request, Activity $activity): JsonResponse
    {
        $validated = $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $activity->students()->syncWithoutDetaching($validated['student_ids']);

        return response()->json($activity->load('students'));
    }

    /**
     * Record score for a student in an activity.
     */
    public function recordScore(Request $request, Activity $activity): JsonResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'score' => 'nullable|integer|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $activity->students()->updateExistingPivot($validated['student_id'], [
            'score' => $validated['score'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json($activity->load('students'));
    }

    /**
     * Get students for an activity.
     */
    public function students(Activity $activity): JsonResponse
    {
        return response()->json($activity->students);
    }
}
