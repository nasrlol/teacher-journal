@extends('layouts.app')

@section('title', $teacher->name . ' - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/teachers.css') }}">
@endpush

@section('content')
<a href="{{ route('teachers.index') }}">Back to Teachers</a>

<h1>{{ $teacher->name }} {{ $teacher->last_name }}</h1>
<p>{{ $teacher->email }}</p>

<a href="{{ route('teachers.edit', $teacher) }}">Edit</a>
<form action="{{ route('teachers.destroy', $teacher) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
</form>

<h2>Groups ({{ $teacher->groups->count() }})</h2>
<a href="{{ route('groups.create') }}">Add Group</a>
@forelse($teacher->groups as $group)
    <div>
        <strong>{{ $group->name }}</strong>
        <small>{{ $group->students->count() }} students</small>
        <a href="{{ route('groups.show', $group) }}">View</a>
    </div>
@empty
    <p>No groups assigned.</p>
@endforelse

<h2>Recent Lessons</h2>
@forelse($teacher->lessons->take(5) as $lesson)
    <div>
        <strong>{{ $lesson->topic }}</strong>
        <small>{{ $lesson->scheduled_at ? $lesson->scheduled_at->format('M j, Y H:i') : 'Not scheduled' }}</small>
        <a href="{{ route('lessons.show', $lesson) }}">View</a>
    </div>
@empty
    <p>No lessons yet.</p>
@endforelse
@endsection
