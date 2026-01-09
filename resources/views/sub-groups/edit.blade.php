@extends('layouts.app')

@section('title', 'Edit Sub Group - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sub-groups.css') }}">
@endpush

@section('content')
<a href="{{ route('sub-groups.index') }}">Back to Sub Groups</a>

<h5>Edit Sub Group</h5>

<form action="{{ route('sub-groups.update', $subGroup) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="name">Sub Group Name</label>
    <input type="text" name="name" id="name" required value="{{ $subGroup->name }}">

    <label for="group_id">Parent Group</label>
    <select name="group_id" id="group_id" required>
        <option value="">Select a parent group</option>
        @foreach($groups as $id => $name)
            <option value="{{ $id }}" @selected($subGroup->group_id == $id)>{{ $name }}</option>
        @endforeach
    </select>

    <button type="submit">Update Sub Group</button>
    <a href="{{ route('sub-groups.index') }}">Cancel</a>
</form>
@endsection
