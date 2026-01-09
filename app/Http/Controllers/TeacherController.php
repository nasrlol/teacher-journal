<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TeacherController extends Controller
{
    /**
     * Display a listing of teachers.
     */
    public function index(Request $request): View|JsonResponse
    {
        $teachers = Teacher::with('groups')->get();

        if ($request->expectsJson()) {
            return response()->json($teachers);
        }

        return view('teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new teacher.
     */
    public function create(): View
    {
        return view('teachers.create');
    }

    /**
     * Store a newly created teacher.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'password' => 'required|string|min:8',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $teacher = Teacher::create($validated);

        if ($request->expectsJson()) {
            return response()->json($teacher, 201);
        }

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified teacher.
     */
    public function show(Request $request, Teacher $teacher): View|JsonResponse
    {
        $teacher->load(['groups', 'lessons']);

        if ($request->expectsJson()) {
            return response()->json($teacher);
        }

        return view('teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified teacher.
     */
    public function edit(Teacher $teacher): View
    {
        return view('teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified teacher.
     */
    public function update(Request $request, Teacher $teacher): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:teachers,email,' . $teacher->id,
            'password' => 'nullable|string|min:8',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $teacher->update($validated);

        if ($request->expectsJson()) {
            return response()->json($teacher);
        }

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified teacher.
     */
    public function destroy(Request $request, Teacher $teacher): JsonResponse|RedirectResponse
    {
        $teacher->delete();

        if ($request->expectsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
