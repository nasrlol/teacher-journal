@extends('layouts.app')

@section('title', 'Add Activity - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/activities.css') }}">
@endpush

@section('content')
<a href="{{ route('activities.index') }}">Back to Activities</a>

<h5>Add New Activity</h5>

<form action="{{ route('activities.store') }}" method="POST">
    @csrf

    <label for="name">Activity Name</label>
    <input type="text" name="name" id="name" required placeholder="Enter activity name">

    <label for="description">Description</label>
    <textarea name="description" id="description" placeholder="Enter activity description (optional)"></textarea>

    <label for="date">Date</label>
    <input type="date" name="date" id="date" required>

    <label for="teacher_id">Teacher</label>
    <select name="teacher_id" id="teacher_id" required>
        <option value="">Select a teacher</option>
        @foreach($teachers as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
    </select>

    <label for="group_id">Group (optional)</label>
    <select name="group_id" id="group_id">
        <option value="">Select a group</option>
        @foreach($groups as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
    </select>

    <button type="submit">Save Activity</button>
    <a href="{{ route('activities.index') }}">Cancel</a>
</form>
@endsection
