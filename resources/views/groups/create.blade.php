@extends('layouts.app')

@section('title', 'Add Group - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/groups.css') }}">
@endpush

@section('content')
<a href="{{ route('groups.index') }}">Back to Groups</a>

<h5>Add New Group</h5>

<form action="{{ route('groups.store') }}" method="POST">
    @csrf

    <label for="name">Group Name</label>
    <input type="text" name="name" id="name" required placeholder="Enter group name">

    <label for="teacher_id">Teacher</label>
    <select name="teacher_id" id="teacher_id" required>
        <option value="">Select a teacher</option>
        @foreach($teachers as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
    </select>

    <button type="submit">Save Group</button>
    <a href="{{ route('groups.index') }}">Cancel</a>
</form>
@endsection
