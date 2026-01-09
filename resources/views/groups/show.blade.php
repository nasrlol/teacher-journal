@extends('layouts.app')

@section('title', $group->name . ' - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/groups.css') }}">
@endpush

@section('content')
<a href="{{ route('groups.index') }}">Back to Groups</a>

<h1>{{ $group->name }}</h1>
@if($group->teacher)
    <p>Teacher: <a href="{{ route('teachers.show', $group->teacher) }}">{{ $group->teacher->name }} {{ $group->teacher->last_name }}</a></p>
@endif

<a href="{{ route('groups.edit', $group) }}">Edit</a>
<form action="{{ route('groups.destroy', $group) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
</form>

<h2>Statistics</h2>
<ul>
    <li>Students: {{ $group->students->count() }}</li>
    <li>Sub Groups: {{ $group->subGroups->count() }}</li>
    <li>Lessons: {{ $group->lessons->count() }}</li>
</ul>

<h2>Students ({{ $group->students->count() }})</h2>
<a href="{{ route('students.create') }}">Add Student</a>
@forelse($group->students as $student)
    <div>
        <strong>{{ $student->name }} {{ $student->last_name }}</strong>
        <small>{{ $student->points ?? 0 }} points</small>
        <a href="{{ route('students.show', $student) }}">View</a>
    </div>
@empty
    <p>No students in this group.</p>
@endforelse

<h2>Sub Groups ({{ $group->subGroups->count() }})</h2>
<a href="{{ route('sub-groups.create') }}">Add Sub Group</a>
@forelse($group->subGroups as $subGroup)
    <div>
        <strong>{{ $subGroup->name }}</strong>
        <small>{{ $subGroup->students->count() }} students</small>
        <a href="{{ route('sub-groups.show', $subGroup) }}">View</a>
    </div>
@empty
    <p>No sub groups.</p>
@endforelse

<h2>Lessons</h2>
<a href="{{ route('lessons.create') }}">Add Lesson</a>
@forelse($group->lessons->take(5) as $lesson)
    <div>
        <strong>{{ $lesson->topic }}</strong>
        <small>{{ $lesson->scheduled_at ? $lesson->scheduled_at->format('M j, Y H:i') : 'Not scheduled' }}</small>
        <a href="{{ route('lessons.show', $lesson) }}">View</a>
    </div>
@empty
    <p>No lessons yet.</p>
@endforelse
@endsection
