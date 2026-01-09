@extends('layouts.app')

@section('title', $subGroup->name . ' - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sub-groups.css') }}">
@endpush

@section('content')
<a href="{{ route('sub-groups.index') }}">Back to Sub Groups</a>

<h1>{{ $subGroup->name }}</h1>
@if($subGroup->group)
    <p>Parent: <a href="{{ route('groups.show', $subGroup->group) }}">{{ $subGroup->group->name }}</a></p>
@endif

<a href="{{ route('sub-groups.edit', $subGroup) }}">Edit</a>
<form action="{{ route('sub-groups.destroy', $subGroup) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
</form>

<p>Students: {{ $subGroup->students->count() }}</p>

<h2>Students ({{ $subGroup->students->count() }})</h2>
<a href="{{ route('students.create') }}">Add Student</a>
@forelse($subGroup->students as $student)
    <div>
        <strong>{{ $student->name }} {{ $student->last_name }}</strong>
        <small>{{ $student->points ?? 0 }} points</small>
        <a href="{{ route('students.show', $student) }}">View</a>
    </div>
@empty
    <p>No students in this sub group.</p>
@endforelse
@endsection
