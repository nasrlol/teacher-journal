@extends('layouts.app')

@section('title', 'Students - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/students.css') }}">
@endpush

@section('content')
<h1>Students</h1>
<a href="{{ route('students.create') }}">Add Student</a>

<form method="GET" action="{{ route('students.index') }}">
    <label for="group_id">Filter by Group</label>
    <select name="group_id" id="group_id">
        <option value="">All Groups</option>
        @foreach($groups as $id => $name)
            <option value="{{ $id }}" @selected(request('group_id') == $id)>{{ $name }}</option>
        @endforeach
    </select>
    <button type="submit">Filter</button>
    @if(request()->hasAny(['group_id']))
        <a href="{{ route('students.index') }}">Clear</a>
    @endif
</form>

@if($students->isEmpty())
    <p>No students found.</p>
    <a href="{{ route('students.create') }}">Add your first student</a>
@else
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
                <th>Group</th>
                <th>Sub Group</th>
                <th>Points</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td><strong>{{ $student->name }} {{ $student->last_name }}</strong></td>
                    <td>{{ $student->age }}</td>
                    <td>
                        @if($student->group)
                            <a href="{{ route('groups.show', $student->group) }}">{{ $student->group->name }}</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($student->subGroup)
                            <a href="{{ route('sub-groups.show', $student->subGroup) }}">{{ $student->subGroup->name }}</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $student->points ?? 0 }}</td>
                    <td>
                        <a href="{{ route('students.show', $student) }}">View</a>
                        <a href="{{ route('students.edit', $student) }}">Edit</a>
                        <form action="{{ route('students.destroy', $student) }}" method="POST" style="display:inline;">
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
