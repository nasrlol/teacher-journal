<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GroupController extends Controller
{
    /**
     * Display a listing of groups.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Group::with(['teacher', 'students', 'subGroups']);

        if ($request->has('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        $groups = $query->get();
        return response()->json($groups);
    }

    /**
     * Store a newly created group.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        $group = Group::create($validated);

        return response()->json($group->load('teacher'), 201);
    }

    /**
     * Display the specified group.
     */
    public function show(Group $group): JsonResponse
    {
        return response()->json($group->load(['teacher', 'students', 'subGroups', 'lessons']));
    }

    /**
     * Update the specified group.
     */
    public function update(Request $request, Group $group): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'teacher_id' => 'sometimes|required|exists:teachers,id',
        ]);

        $group->update($validated);

        return response()->json($group->load('teacher'));
    }

    /**
     * Remove the specified group.
     */
    public function destroy(Group $group): JsonResponse
    {
        $group->delete();

        return response()->json(null, 204);
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
