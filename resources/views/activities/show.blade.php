@extends('layouts.app')

@section('title', $activity->name . ' - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/activities.css') }}">
@endpush

@section('content')
<a href="{{ route('activities.index') }}">Back to Activities</a>

<h1>{{ $activity->name }}</h1>
@if($activity->description)
    <p>{{ $activity->description }}</p>
@endif

<a href="{{ route('activities.edit', $activity) }}">Edit</a>
<form action="{{ route('activities.destroy', $activity) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
</form>

<h2>Details</h2>
<p><strong>Date:</strong> {{ $activity->date->format('M j, Y') }}</p>
<p>
    <strong>Teacher:</strong>
    @if($activity->teacher)
        <a href="{{ route('teachers.show', $activity->teacher) }}">
            {{ $activity->teacher->name }} {{ $activity->teacher->last_name }}
        </a>
    @else
        None
    @endif
</p>
<p>
    <strong>Group:</strong>
    @if($activity->group)
        <a href="{{ route('groups.show', $activity->group) }}">{{ $activity->group->name }}</a>
    @else
        None
    @endif
</p>

<h2>Students ({{ $activity->students->count() }})</h2>
<button onclick="document.getElementById('attachStudentsModal').style.display='block'">Add Students</button>

@forelse($activity->students as $student)
    <div>
        <strong>{{ $student->name }} {{ $student->last_name }}</strong>
        <small>({{ $student->group->name ?? 'No group' }})</small>
        @if($student->pivot->score !== null)
            <span>Score: {{ $student->pivot->score }}</span>
        @endif
        @if($student->pivot->notes)
            <small>{{ Str::limit($student->pivot->notes, 20) }}</small>
        @endif
        <button onclick="openScoreModal({{ $student->id }}, '{{ $student->name }} {{ $student->last_name }}', '{{ $student->pivot->score }}', '{{ $student->pivot->notes }}')">Edit Score</button>
    </div>
@empty
    <p>No students attached to this activity.</p>
@endforelse

<!-- Attach Students Modal -->
<div id="attachStudentsModal" style="display:none;">
    <h3>Add Students to Activity</h3>
    <form action="{{ route('activities.attach-students', $activity) }}" method="POST">
        @csrf
        <p>Select students to add to this activity:</p>
        @foreach($availableStudents as $student)
            <div>
                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" id="student{{ $student->id }}"
                    {{ $activity->students->contains($student->id) ? 'checked' : '' }}>
                <label for="student{{ $student->id }}">
                    {{ $student->name }} {{ $student->last_name }}
                    <small>({{ $student->group->name ?? 'No group' }})</small>
                </label>
            </div>
        @endforeach
        @if($availableStudents->isEmpty())
            <p>No students available. Create students first.</p>
        @endif
        <button type="button" onclick="document.getElementById('attachStudentsModal').style.display='none'">Cancel</button>
        <button type="submit" @if($availableStudents->isEmpty()) disabled @endif>Save</button>
    </form>
</div>

<!-- Record Score Modal -->
<div id="recordScoreModal" style="display:none;">
    <h3>Record Score</h3>
    <form action="{{ route('activities.record-score', $activity) }}" method="POST" id="scoreForm">
        @csrf
        <input type="hidden" name="student_id" id="scoreStudentId">
        <p>Recording score for: <strong id="scoreStudentName"></strong></p>

        <label for="scoreValue">Score</label>
        <input type="number" id="scoreValue" name="score" min="0" placeholder="Enter score">

        <label for="scoreNotes">Notes (optional)</label>
        <textarea id="scoreNotes" name="notes" rows="3" placeholder="Enter notes"></textarea>

        <button type="button" onclick="document.getElementById('recordScoreModal').style.display='none'">Cancel</button>
        <button type="submit">Save</button>
    </form>
</div>

<script>
function openScoreModal(studentId, studentName, score, notes) {
    document.getElementById('scoreStudentId').value = studentId;
    document.getElementById('scoreStudentName').textContent = studentName;
    document.getElementById('scoreValue').value = score || '';
    document.getElementById('scoreNotes').value = notes || '';
    document.getElementById('recordScoreModal').style.display = 'block';
}
</script>
@endsection

