@extends('layouts.app')

@section('title', 'Lessons - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/lessons.css') }}">
@endpush

@section('content')
<h1>Lessons</h1>
<a href="{{ route('lessons.create') }}">Add Lesson</a>

<form method="GET" action="{{ route('lessons.index') }}">
    <label for="group_id">Filter by Group</label>
    <select name="group_id" id="group_id">
        <option value="">All Groups</option>
        @foreach($groups as $id => $name)
            <option value="{{ $id }}" @selected(request('group_id') == $id)>{{ $name }}</option>
        @endforeach
    </select>

    <label for="teacher_id">Filter by Teacher</label>
    <select name="teacher_id" id="teacher_id">
        <option value="">All Teachers</option>
        @foreach($teachers as $id => $name)
            <option value="{{ $id }}" @selected(request('teacher_id') == $id)>{{ $name }}</option>
        @endforeach
    </select>

    <label for="date">Filter by Date</label>
    <input type="date" name="date" id="date" value="{{ request('date') }}">

    <button type="submit">Filter</button>
    @if(request()->hasAny(['group_id', 'teacher_id', 'date']))
        <a href="{{ route('lessons.index') }}">Clear</a>
    @endif
</form>

@if($lessons->isEmpty())
    <p>No lessons found.</p>
    <a href="{{ route('lessons.create') }}">Add your first lesson</a>
@else
    <table>
        <thead>
            <tr>
                <th>Topic</th>
                <th>Teacher</th>
                <th>Group</th>
                <th>Scheduled</th>
                <th>Duration</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lessons as $lesson)
                <tr>
                    <td>
                        <strong>{{ $lesson->topic }}</strong>
                        @if($lesson->description)
                            <br><small>{{ Str::limit($lesson->description, 50) }}</small>
                        @endif
                    </td>
                    <td>
                        @if($lesson->teacher)
                            <a href="{{ route('teachers.show', $lesson->teacher) }}">{{ $lesson->teacher->name }}</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($lesson->group)
                            <a href="{{ route('groups.show', $lesson->group) }}">{{ $lesson->group->name }}</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $lesson->scheduled_at ? $lesson->scheduled_at->format('M j, Y H:i') : 'Not scheduled' }}</td>
                    <td>{{ $lesson->duration_minutes ? $lesson->duration_minutes . ' min' : '-' }}</td>
                    <td>
                        <a href="{{ route('lessons.show', $lesson) }}">View</a>
                        <a href="{{ route('lessons.edit', $lesson) }}">Edit</a>
                        <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
