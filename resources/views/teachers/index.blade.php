@extends('layouts.app')

@section('title', 'Teachers - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/teachers.css') }}">
@endpush

@section('content')
<h1>Teachers</h1>
<a href="{{ route('teachers.create') }}">Add Teacher</a>

@if($teachers->isEmpty())
    <p>No teachers found.</p>
    <a href="{{ route('teachers.create') }}">Add your first teacher</a>
@else
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Groups</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
                <tr>
                    <td><strong>{{ $teacher->name }} {{ $teacher->last_name }}</strong></td>
                    <td>{{ $teacher->email }}</td>
                    <td>{{ $teacher->groups->count() }}</td>
                    <td>
                        <a href="{{ route('teachers.show', $teacher) }}">View</a>
                        <a href="{{ route('teachers.edit', $teacher) }}">Edit</a>
                        <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" style="display:inline;">
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
