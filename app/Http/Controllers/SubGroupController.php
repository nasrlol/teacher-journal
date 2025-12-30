<?php

namespace App\Http\Controllers;

use App\Models\SubGroup;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SubGroupController extends Controller
{
    /**
     * Display a listing of sub-groups.
     */
    public function index(Request $request): JsonResponse
    {
        $query = SubGroup::with(['group', 'students']);

        if ($request->has('group_id')) {
            $query->where('group_id', $request->group_id);
        }

        $subGroups = $query->get();
        return response()->json($subGroups);
    }

    /**
     * Store a newly created sub-group.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'group_id' => 'required|exists:groups,id',
        ]);

        $subGroup = SubGroup::create($validated);

        return response()->json($subGroup->load('group'), 201);
    }

    /**
     * Display the specified sub-group.
     */
    public function show(SubGroup $subGroup): JsonResponse
    {
        return response()->json($subGroup->load(['group', 'students']));
    }

    /**
     * Update the specified sub-group.
     */
    public function update(Request $request, SubGroup $subGroup): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'group_id' => 'sometimes|required|exists:groups,id',
        ]);

        $subGroup->update($validated);

        return response()->json($subGroup->load('group'));
    }

    /**
     * Remove the specified sub-group.
     */
    public function destroy(SubGroup $subGroup): JsonResponse
    {
        $subGroup->delete();

        return response()->json(null, 204);
    }

    /**
     * Get students in a sub-group.
     */
    public function students(SubGroup $subGroup): JsonResponse
    {
        return response()->json($subGroup->students);
    }
}
