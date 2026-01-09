@extends('layouts.app')

@section('title', 'Groups - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/groups.css') }}">
@endpush

@section('content')
<h1>Groups</h1>
<a href="{{ route('groups.create') }}">Add Group</a>

@if($groups->isEmpty())
    <p>No groups found.</p>
    <a href="{{ route('groups.create') }}">Add your first group</a>
@else
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Teacher</th>
                <th>Students</th>
                <th>Sub Groups</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groups as $group)
                <tr>
                    <td><strong>{{ $group->name }}</strong></td>
                    <td>
                        @if($group->teacher)
                            <a href="{{ route('teachers.show', $group->teacher) }}">
                                {{ $group->teacher->name }} {{ $group->teacher->last_name }}
                            </a>
                        @else
                            No teacher
                        @endif
                    </td>
                    <td>{{ $group->students->count() }}</td>
                    <td>{{ $group->subGroups->count() }}</td>
                    <td>
                        <a href="{{ route('groups.show', $group) }}">View</a>
                        <a href="{{ route('groups.edit', $group) }}">Edit</a>
                        <form action="{{ route('groups.destroy', $group) }}" method="POST" style="display:inline;">
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
