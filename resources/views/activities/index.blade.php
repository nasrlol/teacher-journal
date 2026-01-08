@extends('layouts.app')

@section('title', 'Activities - Teacher Journal')

@section('content')
<h1>Activities</h1>
<a href="{{ route('activities.create') }}">Add Activity</a>

<form method="GET" action="{{ route('activities.index') }}">
    <label for="group_id">Filter by Group</label>
    <select name="group_id" id="group_id">
        <option value="">All Groups</option>
        @foreach($groups as $id => $name)
            <option value="{{ $id }}" @selected(request('group_id') == $id)>{{ $name }}</option>
        @endforeach
    </select>

    <label for="date">Filter by Date</label>
    <input type="date" name="date" id="date" value="{{ request('date') }}">

    <button type="submit">Filter</button>
    @if(request()->hasAny(['group_id', 'date']))
        <a href="{{ route('activities.index') }}">Clear</a>
    @endif
</form>

@if($activities->isEmpty())
    <p>No activities found.</p>
    <a href="{{ route('activities.create') }}">Add your first activity</a>
@else
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Teacher</th>
                <th>Group</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
                <tr>
                    <td>
                        <strong>{{ $activity->name }}</strong>
                        @if($activity->description)
                            <br><small>{{ Str::limit($activity->description, 50) }}</small>
                        @endif
                    </td>
                    <td>
                        @if($activity->teacher)
                            <a href="{{ route('teachers.show', $activity->teacher) }}">{{ $activity->teacher->name }}</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($activity->group)
                            <a href="{{ route('groups.show', $activity->group) }}">{{ $activity->group->name }}</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $activity->date->format('M j, Y') }}</td>
                    <td>
                        <a href="{{ route('activities.show', $activity) }}">View</a>
                        <a href="{{ route('activities.edit', $activity) }}">Edit</a>
                        <form action="{{ route('activities.destroy', $activity) }}" method="POST" style="display:inline;">
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

