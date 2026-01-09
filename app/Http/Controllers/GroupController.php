<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class GroupController extends Controller
{
    /**
     * Display a listing of groups.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = Group::with(['teacher', 'students', 'subGroups']);

        if ($request->has('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        $groups = $query->get();

        if ($request->expectsJson()) {
            return response()->json($groups);
        }

        return view('groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new group.
     */
    public function create(): View
    {
        $teachers = Teacher::all()->pluck('name', 'id')->map(function ($name, $id) {
            $teacher = Teacher::find($id);
            return $teacher->name . ' ' . $teacher->last_name;
        });

        return view('groups.create', compact('teachers'));
    }

    /**
     * Store a newly created group.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        $group = Group::create($validated);

        if ($request->expectsJson()) {
            return response()->json($group->load('teacher'), 201);
        }

        return redirect()->route('groups.index')->with('success', 'Group created successfully.');
    }

    /**
     * Display the specified group.
     */
    public function show(Request $request, Group $group): View|JsonResponse
    {
        $group->load(['teacher', 'students', 'subGroups', 'lessons']);

        if ($request->expectsJson()) {
            return response()->json($group);
        }

        return view('groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified group.
     */
    public function edit(Group $group): View
    {
        $teachers = Teacher::all()->mapWithKeys(function ($teacher) {
            return [$teacher->id => $teacher->name . ' ' . $teacher->last_name];
        });

        return view('groups.edit', compact('group', 'teachers'));
    }

    /**
     * Update the specified group.
     */
    public function update(Request $request, Group $group): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'teacher_id' => 'sometimes|required|exists:teachers,id',
        ]);

        $group->update($validated);

        if ($request->expectsJson()) {
            return response()->json($group->load('teacher'));
        }

        return redirect()->route('groups.index')->with('success', 'Group updated successfully.');
    }

    /**
     * Remove the specified group.
     */
    public function destroy(Request $request, Group $group): JsonResponse|RedirectResponse
    {
        $group->delete();

        if ($request->expectsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('groups.index')->with('success', 'Group deleted successfully.');
    }

    /**
     * Get students in a group.
     */
    public function students(Group $group): JsonResponse
    {
        return response()->json($group->students);
    }

    /**
     * Get lessons for a group.
     */
    public function lessons(Group $group): JsonResponse
    {
        return response()->json($group->lessons);
    }
}
