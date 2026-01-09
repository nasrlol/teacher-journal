@extends('layouts.app')

@section('title', 'Add Sub Group - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sub-groups.css') }}">
@endpush

@section('content')
<a href="{{ route('sub-groups.index') }}">Back to Sub Groups</a>

<h5>Add New Sub Group</h5>

<form action="{{ route('sub-groups.store') }}" method="POST">
    @csrf

    <label for="name">Sub Group Name</label>
    <input type="text" name="name" id="name" required placeholder="Enter sub group name">

    <label for="group_id">Parent Group</label>
    <select name="group_id" id="group_id" required>
        <option value="">Select a parent group</option>
        @foreach($groups as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
    </select>

    <button type="submit">Save Sub Group</button>
    <a href="{{ route('sub-groups.index') }}">Cancel</a>
</form>
@endsection
