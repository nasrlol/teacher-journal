<?php

namespace App\Http\Controllers;

use App\Models\SubGroup;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SubGroupController extends Controller
{
    /**
     * Display a listing of sub-groups.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = SubGroup::with(['group', 'students']);

        if ($request->has('group_id') && $request->group_id) {
            $query->where('group_id', $request->group_id);
        }

        $subGroups = $query->get();

        if ($request->expectsJson()) {
            return response()->json($subGroups);
        }

        return view('sub-groups.index', compact('subGroups'));
    }

    /**
     * Show the form for creating a new sub-group.
     */
    public function create(): View
    {
        $groups = Group::pluck('name', 'id');
        return view('sub-groups.create', compact('groups'));
    }

    /**
     * Store a newly created sub-group.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'group_id' => 'required|exists:groups,id',
        ]);

        $subGroup = SubGroup::create($validated);

        if ($request->expectsJson()) {
            return response()->json($subGroup->load('group'), 201);
        }

        return redirect()->route('sub-groups.index')->with('success', 'Sub group created successfully.');
    }

    /**
     * Display the specified sub-group.
     */
    public function show(Request $request, SubGroup $subGroup): View|JsonResponse
    {
        $subGroup->load(['group', 'students']);

        if ($request->expectsJson()) {
            return response()->json($subGroup);
        }

        return view('sub-groups.show', compact('subGroup'));
    }

    /**
     * Show the form for editing the specified sub-group.
     */
    public function edit(SubGroup $subGroup): View
    {
        $groups = Group::pluck('name', 'id');
        return view('sub-groups.edit', compact('subGroup', 'groups'));
    }

    /**
     * Update the specified sub-group.
     */
    public function update(Request $request, SubGroup $subGroup): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'group_id' => 'sometimes|required|exists:groups,id',
        ]);

        $subGroup->update($validated);

        if ($request->expectsJson()) {
            return response()->json($subGroup->load('group'));
        }

        return redirect()->route('sub-groups.index')->with('success', 'Sub group updated successfully.');
    }

    /**
     * Remove the specified sub-group.
     */
    public function destroy(Request $request, SubGroup $subGroup): JsonResponse|RedirectResponse
    {
        $subGroup->delete();

        if ($request->expectsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('sub-groups.index')->with('success', 'Sub group deleted successfully.');
    }

    /**
     * Get students in a sub-group.
     */
    public function students(SubGroup $subGroup): JsonResponse
    {
        return response()->json($subGroup->students);
    }
}
