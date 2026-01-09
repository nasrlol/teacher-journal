@extends('layouts.app')

@section('title', 'Edit Student - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/students.css') }}">
@endpush

@section('content')
<a href="{{ route('students.index') }}">Back to Students</a>

<h5>Edit Student</h5>

<form action="{{ route('students.update', $student) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="name">First Name</label>
    <input type="text" name="name" id="name" required value="{{ $student->name }}">

    <label for="last_name">Last Name</label>
    <input type="text" name="last_name" id="last_name" required value="{{ $student->last_name }}">

    <label for="age">Age</label>
    <input type="number" name="age" id="age" required min="1" max="120" value="{{ $student->age }}">

    <label for="enrollment_date">Enrollment Date</label>
    <input type="date" name="enrollment_date" id="enrollment_date" value="{{ $student->enrollment_date?->format('Y-m-d') }}">

    <label for="group_id">Group</label>
    <select name="group_id" id="group_id" required>
        <option value="">Select a group</option>
        @foreach($groups as $id => $name)
            <option value="{{ $id }}" @selected($student->group_id == $id)>{{ $name }}</option>
        @endforeach
    </select>

    <label for="sub_group_id">Sub Group</label>
    <select name="sub_group_id" id="sub_group_id">
        <option value="">Select a sub group (optional)</option>
        @foreach($subGroups as $id => $name)
            <option value="{{ $id }}" @selected($student->sub_group_id == $id)>{{ $name }}</option>
        @endforeach
    </select>

    <label for="points">Points</label>
    <input type="number" name="points" id="points" min="0" value="{{ $student->points ?? 0 }}">

    <button type="submit">Update Student</button>
    <a href="{{ route('students.index') }}">Cancel</a>
</form>
@endsection
