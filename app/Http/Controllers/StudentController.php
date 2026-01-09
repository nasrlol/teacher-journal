<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Group;
use App\Models\SubGroup;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = Student::with(['group', 'subGroup']);

        if ($request->has('group_id') && $request->group_id) {
            $query->where('group_id', $request->group_id);
        }

        if ($request->has('sub_group_id') && $request->sub_group_id) {
            $query->where('sub_group_id', $request->sub_group_id);
        }

        $students = $query->get();

        if ($request->expectsJson()) {
            return response()->json($students);
        }

        $groups = Group::pluck('name', 'id');
        return view('students.index', compact('students', 'groups'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create(): View
    {
        $groups = Group::pluck('name', 'id');
        $subGroups = SubGroup::all()->mapWithKeys(function ($subGroup) {
            return [$subGroup->id => $subGroup->name . ' (' . ($subGroup->group->name ?? 'No group') . ')'];
        });

        return view('students.create', compact('groups', 'subGroups'));
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
            'group_id' => 'required|exists:groups,id',
            'sub_group_id' => 'nullable|exists:sub_groups,id',
            'points' => 'nullable|integer|min:0',
            'enrollment_date' => 'nullable|date',
        ]);

        $student = Student::create($validated);

        if ($request->expectsJson()) {
            return response()->json($student->load(['group', 'subGroup']), 201);
        }

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified student.
     */
    public function show(Request $request, Student $student): View|JsonResponse
    {
        $student->load(['group', 'subGroup', 'lessons', 'activities']);

        if ($request->expectsJson()) {
            return response()->json($student);
        }

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student): View
    {
        $groups = Group::pluck('name', 'id');
        $subGroups = SubGroup::all()->mapWithKeys(function ($subGroup) {
            return [$subGroup->id => $subGroup->name . ' (' . ($subGroup->group->name ?? 'No group') . ')'];
        });

        return view('students.edit', compact('student', 'groups', 'subGroups'));
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, Student $student): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'age' => 'sometimes|required|integer|min:1|max:120',
            'group_id' => 'sometimes|required|exists:groups,id',
            'sub_group_id' => 'nullable|exists:sub_groups,id',
            'points' => 'nullable|integer|min:0',
            'enrollment_date' => 'nullable|date',
        ]);

        $student->update($validated);

        if ($request->expectsJson()) {
            return response()->json($student->load(['group', 'subGroup']));
        }

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student.
     */
    public function destroy(Request $request, Student $student): JsonResponse|RedirectResponse
    {
        $student->delete();

        if ($request->expectsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    /**
     * Add points to a student.
     */
    public function addPoints(Request $request, Student $student): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'points' => 'required|integer',
        ]);

        $student->increment('points', $validated['points']);

        if ($request->expectsJson()) {
            return response()->json($student);
        }

        return redirect()->back()->with('success', 'Points added successfully.');
    }
}
