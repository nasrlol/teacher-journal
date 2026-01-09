@extends('layouts.app')

@section('title', 'Sub Groups - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sub-groups.css') }}">
@endpush

@section('content')
<h1>Sub Groups</h1>
<a href="{{ route('sub-groups.create') }}">Add Sub Group</a>

@if($subGroups->isEmpty())
    <p>No sub groups found.</p>
    <a href="{{ route('sub-groups.create') }}">Add your first sub group</a>
@else
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Parent Group</th>
                <th>Students</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subGroups as $subGroup)
                <tr>
                    <td><strong>{{ $subGroup->name }}</strong></td>
                    <td>
                        @if($subGroup->group)
                            <a href="{{ route('groups.show', $subGroup->group) }}">{{ $subGroup->group->name }}</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $subGroup->students->count() }}</td>
                    <td>
                        <a href="{{ route('sub-groups.show', $subGroup) }}">View</a>
                        <a href="{{ route('sub-groups.edit', $subGroup) }}">Edit</a>
                        <form action="{{ route('sub-groups.destroy', $subGroup) }}" method="POST" style="display:inline;">
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
