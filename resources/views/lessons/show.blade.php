@extends('layouts.app')

@section('title', $lesson->topic . ' - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/lessons.css') }}">
@endpush

@section('content')
<a href="{{ route('lessons.index') }}">Back to Lessons</a>

<h1>{{ $lesson->topic }}</h1>
@if($lesson->description)
    <p>{{ $lesson->description }}</p>
@endif

<a href="{{ route('lessons.edit', $lesson) }}">Edit</a>
<form action="{{ route('lessons.destroy', $lesson) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
</form>

<h2>Details</h2>
<p>
    <strong>Teacher:</strong>
    @if($lesson->teacher)
        <a href="{{ route('teachers.show', $lesson->teacher) }}">{{ $lesson->teacher->name }} {{ $lesson->teacher->last_name }}</a>
    @else
        None
    @endif
</p>
<p>
    <strong>Group:</strong>
    @if($lesson->group)
        <a href="{{ route('groups.show', $lesson->group) }}">{{ $lesson->group->name }}</a>
    @else
        None
    @endif
</p>
<p><strong>Scheduled:</strong> {{ $lesson->scheduled_at ? $lesson->scheduled_at->format('M j, Y H:i') : 'Not scheduled' }}</p>
<p><strong>Duration:</strong> {{ $lesson->duration_minutes ? $lesson->duration_minutes . ' minutes' : 'Not set' }}</p>

<h2>Students ({{ $lesson->students->count() }})</h2>
<button onclick="document.getElementById('attachStudentsModal').style.display='block'">Add Students</button>

@forelse($lesson->students as $student)
    <div>
        <strong>{{ $student->name }} {{ $student->last_name }}</strong>
        <small>({{ $student->group->name ?? 'No group' }})</small>
        @if($student->pivot->attendance)
            <span>Present</span>
        @else
            <span>Absent</span>
        @endif
        @if($student->pivot->score !== null)
            <span>{{ $student->pivot->score }}%</span>
        @endif
        <button onclick="openAttendanceModal({{ $student->id }}, '{{ $student->name }} {{ $student->last_name }}', '{{ $student->pivot->attendance ? '1' : '0' }}', '{{ $student->pivot->score }}')">Edit</button>
    </div>
@empty
    <p>No students attached to this lesson.</p>
@endforelse

<!-- Attach Students Modal -->
<div id="attachStudentsModal" style="display:none;">
    <h3>Add Students to Lesson</h3>
    <form action="{{ route('lessons.attach-students', $lesson) }}" method="POST">
        @csrf
        <p>Select students to add to this lesson:</p>
        @foreach($availableStudents as $student)
            <div>
                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" id="student{{ $student->id }}"
                    {{ $lesson->students->contains($student->id) ? 'checked' : '' }}>
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

<!-- Record Attendance Modal -->
<div id="recordAttendanceModal" style="display:none;">
    <h3>Record Attendance</h3>
    <form action="{{ route('lessons.record-attendance', $lesson) }}" method="POST" id="attendanceForm">
        @csrf
        <input type="hidden" name="student_id" id="attendanceStudentId">
        <p>Recording attendance for: <strong id="attendanceStudentName"></strong></p>

        <label>Attendance</label>
        <div>
            <input type="radio" name="attendance" id="attendancePresent" value="1">
            <label for="attendancePresent">Present</label>
        </div>
        <div>
            <input type="radio" name="attendance" id="attendanceAbsent" value="0">
            <label for="attendanceAbsent">Absent</label>
        </div>

        <label for="attendanceScore">Score (optional)</label>
        <input type="number" id="attendanceScore" name="score" min="0" max="100" placeholder="0-100">

        <button type="button" onclick="document.getElementById('recordAttendanceModal').style.display='none'">Cancel</button>
        <button type="submit">Save</button>
    </form>
</div>

<script>
function openAttendanceModal(studentId, studentName, attendance, score) {
    document.getElementById('attendanceStudentId').value = studentId;
    document.getElementById('attendanceStudentName').textContent = studentName;
    document.getElementById('attendanceScore').value = score || '';
    if (attendance === '1') {
        document.getElementById('attendancePresent').checked = true;
    } else {
        document.getElementById('attendanceAbsent').checked = true;
    }
    document.getElementById('recordAttendanceModal').style.display = 'block';
}
</script>
@endsection

