@extends('layouts.app')

@section('title', 'Dashboard - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
<h1>Dashboard</h1>
<p>{{ now()->format('l, F j, Y') }}</p>

<h2>Statistics</h2>
<ul>
    <li>Teachers: {{ $teacherCount }} - <a href="{{ route('teachers.index') }}">View all</a></li>
    <li>Groups: {{ $groupCount }} - <a href="{{ route('groups.index') }}">View all</a></li>
    <li>Students: {{ $studentCount }} - <a href="{{ route('students.index') }}">View all</a></li>
    <li>Lessons: {{ $lessonCount }} - <a href="{{ route('lessons.index') }}">View all</a></li>
</ul>

<h2>Recent Lessons</h2>
@forelse($recentLessons as $lesson)
    <div>
        <strong>{{ $lesson->topic }}</strong>
        <br>
        <small>{{ $lesson->group->name ?? 'No group' }} • {{ $lesson->scheduled_at ? $lesson->scheduled_at->format('M j, Y') : 'Not scheduled' }}</small>
        <a href="{{ route('lessons.show', $lesson) }}">View</a>
    </div>
@empty
    <p>No lessons yet.</p>
@endforelse
@if($recentLessons->count() > 0)
    <a href="{{ route('lessons.index') }}">View all lessons</a>
@endif

<h2>Top Students by Points</h2>
@forelse($topStudents as $student)
    <div>
        <strong>{{ $student->name }} {{ $student->last_name }}</strong>
        <small>({{ $student->group->name ?? 'No group' }})</small>
        <span>{{ $student->points ?? 0 }} pts</span>
    </div>
@empty
    <p>No students yet.</p>
@endforelse
@if($topStudents->count() > 0)
    <a href="{{ route('students.index') }}">View all students</a>
@endif
@endsection
