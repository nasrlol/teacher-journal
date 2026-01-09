@extends('layouts.app')

@section('title', 'Add Student - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/students.css') }}">
@endpush

@section('content')
<a href="{{ route('students.index') }}">Back to Students</a>

<h5>Add New Student</h5>

<form action="{{ route('students.store') }}" method="POST">
    @csrf

    <label for="name">First Name</label>
    <input type="text" name="name" id="name" required placeholder="Enter first name">

    <label for="last_name">Last Name</label>
    <input type="text" name="last_name" id="last_name" required placeholder="Enter last name">

    <label for="age">Age</label>
    <input type="number" name="age" id="age" required min="1" max="120" placeholder="Enter age">

    <label for="enrollment_date">Enrollment Date</label>
    <input type="date" name="enrollment_date" id="enrollment_date">

    <label for="group_id">Group</label>
    <select name="group_id" id="group_id" required>
        <option value="">Select a group</option>
        @foreach($groups as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
    </select>

    <label for="sub_group_id">Sub Group</label>
    <select name="sub_group_id" id="sub_group_id">
        <option value="">Select a sub group (optional)</option>
        @foreach($subGroups as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
    </select>

    <label for="points">Initial Points</label>
    <input type="number" name="points" id="points" min="0" value="0">

    <button type="submit">Save Student</button>
    <a href="{{ route('students.index') }}">Cancel</a>
</form>
@endsection
