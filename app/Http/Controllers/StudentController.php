<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Student::with(['group', 'subGroup']);

        if ($request->has('group_id')) {
            $query->where('group_id', $request->group_id);
        }

        if ($request->has('sub_group_id')) {
            $query->where('sub_group_id', $request->sub_group_id);
        }

        $students = $query->get();
        return response()->json($students);
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request): JsonResponse
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

        return response()->json($student->load(['group', 'subGroup']), 201);
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student): JsonResponse
    {
        return response()->json($student->load(['group', 'subGroup', 'lessons', 'activities']));
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, Student $student): JsonResponse
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

        return response()->json($student->load(['group', 'subGroup']));
    }

    /**
     * Remove the specified student.
     */
    public function destroy(Student $student): JsonResponse
    {
        $student->delete();

        return response()->json(null, 204);
    }

    /**
     * Add points to a student.
     */
    public function addPoints(Request $request, Student $student): JsonResponse
    {
        $validated = $request->validate([
            'points' => 'required|integer',
        ]);

        $student->increment('points', $validated['points']);

        return response()->json($student);
    }
}
