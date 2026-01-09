<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Teacher;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of activities.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = Activity::with(['teacher', 'group']);

        if ($request->has('teacher_id') && $request->teacher_id) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->has('group_id') && $request->group_id) {
            $query->where('group_id', $request->group_id);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('date', $request->date);
        }

        $activities = $query->orderBy('date', 'desc')->get();

        if ($request->expectsJson()) {
            return response()->json($activities);
        }

        $groups = Group::pluck('name', 'id');
        return view('activities.index', compact('activities', 'groups'));
    }

    /**
     * Show the form for creating a new activity.
     */
    public function create(): View
    {
        $groups = Group::pluck('name', 'id');
        $teachers = Teacher::all()->mapWithKeys(function ($teacher) {
            return [$teacher->id => $teacher->name . ' ' . $teacher->last_name];
        });

        return view('activities.create', compact('groups', 'teachers'));
    }

    /**
     * Store a newly created activity.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'teacher_id' => 'required|exists:teachers,id',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $activity = Activity::create($validated);

        if ($request->expectsJson()) {
            return response()->json($activity->load(['teacher', 'group']), 201);
        }

        return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
    }

    /**
     * Display the specified activity.
     */
    public function show(Request $request, Activity $activity): View|JsonResponse
    {
        $activity->load(['teacher', 'group', 'students']);

        if ($request->expectsJson()) {
            return response()->json($activity);
        }

        $availableStudents = Student::with('group')->get();
        return view('activities.show', compact('activity', 'availableStudents'));
    }

    /**
     * Show the form for editing the specified activity.
     */
    public function edit(Activity $activity): View
    {
        $groups = Group::pluck('name', 'id');
        $teachers = Teacher::all()->mapWithKeys(function ($teacher) {
            return [$teacher->id => $teacher->name . ' ' . $teacher->last_name];
        });

        return view('activities.edit', compact('activity', 'groups', 'teachers'));
    }

    /**
     * Update the specified activity.
     */
    public function update(Request $request, Activity $activity): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'sometimes|required|date',
            'teacher_id' => 'sometimes|required|exists:teachers,id',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $activity->update($validated);

        if ($request->expectsJson()) {
            return response()->json($activity->load(['teacher', 'group']));
        }

        return redirect()->route('activities.index')->with('success', 'Activity updated successfully.');
    }

    /**
     * Remove the specified activity.
     */
    public function destroy(Request $request, Activity $activity): JsonResponse|RedirectResponse
    {
        $activity->delete();

        if ($request->expectsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('activities.index')->with('success', 'Activity deleted successfully.');
    }

    /**
     * Attach students to an activity.
     */
    public function attachStudents(Request $request, Activity $activity): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $activity->students()->sync($validated['student_ids']);

        if ($request->expectsJson()) {
            return response()->json($activity->load('students'));
        }

        return redirect()->back()->with('success', 'Students attached successfully.');
    }

    /**
     * Record score for a student in an activity.
     */
    public function recordScore(Request $request, Activity $activity): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'score' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $activity->students()->updateExistingPivot($validated['student_id'], [
            'score' => $validated['score'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        if ($request->expectsJson()) {
            return response()->json($activity->load('students'));
        }

        return redirect()->back()->with('success', 'Score recorded successfully.');
    }

    /**
     * Get students for an activity.
     */
    public function students(Activity $activity): JsonResponse
    {
        return response()->json($activity->students);
    }
}
