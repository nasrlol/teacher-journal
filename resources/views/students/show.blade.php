@extends('layouts.app')

@section('title', $student->name . ' - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/students.css') }}">
@endpush

@section('content')
<a href="{{ route('students.index') }}">Back to Students</a>

<h1>{{ $student->name }} {{ $student->last_name }}</h1>
<p>Age: {{ $student->age }}</p>
@if($student->group)
    <p>Group: <a href="{{ route('groups.show', $student->group) }}">{{ $student->group->name }}</a></p>
@endif

<a href="{{ route('students.edit', $student) }}">Edit</a>
<form action="{{ route('students.destroy', $student) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
</form>

<h2>Points</h2>
<p><strong>{{ $student->points ?? 0 }}</strong></p>
<form action="{{ route('students.add-points', $student) }}" method="POST" style="display:inline;">
    @csrf
    <input type="number" name="points" placeholder="Add points" required>
    <button type="submit">Add</button>
</form>

<h2>Details</h2>
<p>
    <strong>Sub Group:</strong>
    @if($student->subGroup)
        <a href="{{ route('sub-groups.show', $student->subGroup) }}">{{ $student->subGroup->name }}</a>
    @else
        None
    @endif
</p>
<p><strong>Enrollment:</strong> {{ $student->enrollment_date ? $student->enrollment_date->format('M j, Y') : 'Not set' }}</p>
<p><strong>Created:</strong> {{ $student->created_at->format('M j, Y') }}</p>

<h2>Lessons Attended</h2>
@forelse($student->lessons as $lesson)
    <div>
        <strong>{{ $lesson->topic }}</strong>
        <small>{{ $lesson->scheduled_at ? $lesson->scheduled_at->format('M j, Y H:i') : 'Not scheduled' }}</small>
        @if($lesson->pivot->attendance)
            <span>Present</span>
        @else
            <span>Absent</span>
        @endif
        @if($lesson->pivot->score !== null)
            <span>{{ $lesson->pivot->score }}%</span>
        @endif
    </div>
@empty
    <p>No lessons attended yet.</p>
@endforelse

<h2>Activities</h2>
@forelse($student->activities as $activity)
    <div>
        <strong>{{ $activity->name }}</strong>
        <small>{{ $activity->date ? $activity->date->format('M j, Y') : 'No date' }}</small>
        @if($activity->pivot->score !== null)
            <span>Score: {{ $activity->pivot->score }}</span>
        @endif
        @if($activity->pivot->notes)
            <small>{{ $activity->pivot->notes }}</small>
        @endif
    </div>
@empty
    <p>No activities yet.</p>
@endforelse
@endsection

