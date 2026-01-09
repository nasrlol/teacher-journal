@extends('layouts.app')

@section('title', 'Edit Group - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/groups.css') }}">
@endpush

@section('content')
<a href="{{ route('groups.index') }}">Back to Groups</a>

<h5>Edit Group</h5>

<form action="{{ route('groups.update', $group) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="name">Group Name</label>
    <input type="text" name="name" id="name" required value="{{ $group->name }}">

    <label for="teacher_id">Teacher</label>
    <select name="teacher_id" id="teacher_id" required>
        <option value="">Select a teacher</option>
        @foreach($teachers as $id => $name)
            <option value="{{ $id }}" @selected($group->teacher_id == $id)>{{ $name }}</option>
        @endforeach
    </select>

    <button type="submit">Update Group</button>
    <a href="{{ route('groups.index') }}">Cancel</a>
</form>
@endsection
