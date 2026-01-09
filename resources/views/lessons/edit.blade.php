@extends('layouts.app')

@section('title', 'Edit Lesson - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/lessons.css') }}">
@endpush

@section('content')
<a href="{{ route('lessons.index') }}">Back to Lessons</a>

<h5>Edit Lesson</h5>

<form action="{{ route('lessons.update', $lesson) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="topic">Topic</label>
    <input type="text" name="topic" id="topic" required value="{{ $lesson->topic }}">

    <label for="description">Description</label>
    <textarea name="description" id="description">{{ $lesson->description }}</textarea>

    <label for="teacher_id">Teacher</label>
    <select name="teacher_id" id="teacher_id" required>
        <option value="">Select a teacher</option>
        @foreach($teachers as $id => $name)
            <option value="{{ $id }}" @selected($lesson->teacher_id == $id)>{{ $name }}</option>
        @endforeach
    </select>

    <label for="group_id">Group</label>
    <select name="group_id" id="group_id" required>
        <option value="">Select a group</option>
        @foreach($groups as $id => $name)
            <option value="{{ $id }}" @selected($lesson->group_id == $id)>{{ $name }}</option>
        @endforeach
    </select>

    <label for="scheduled_at">Scheduled Date & Time</label>
    <input type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{ $lesson->scheduled_at?->format('Y-m-d\TH:i') }}">

    <label for="duration_minutes">Duration (minutes)</label>
    <input type="number" name="duration_minutes" id="duration_minutes" min="1" value="{{ $lesson->duration_minutes }}">

    <button type="submit">Update Lesson</button>
    <a href="{{ route('lessons.index') }}">Cancel</a>
</form>
@endsection
