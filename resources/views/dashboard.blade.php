@extends('layouts.app')

@section('title', 'Dashboard - Teacher Journal')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
    <div class="dashboard-header">
        <h1>Dashboard</h1>
        <p class="dashboard-date">{{ now()->format('l, F j, Y') }}</p>
    </div>

    <div class="stats-list">
        <div class="stat-card">
            <span class="stat-number">{{ $teacherCount }}</span>
            <span class="stat-label">Teachers</span>
            <a href="{{ route('teachers.index') }}">View all</a>
        </div>
        <div class="stat-card">
            <span class="stat-number">{{ $groupCount }}</span>
            <span class="stat-label">Groups</span>
            <a href="{{ route('groups.index') }}">View all</a>
        </div>
        <div class="stat-card">
            <span class="stat-number">{{ $studentCount }}</span>
            <span class="stat-label">Students</span>
            <a href="{{ route('students.index') }}">View all</a>
        </div>
        <div class="stat-card">
            <span class="stat-number">{{ $lessonCount }}</span>
            <span class="stat-label">Lessons</span>
            <a href="{{ route('lessons.index') }}">View all</a>
        </div>
    </div>

    <div class="dashboard-section news-section">
        <h2>Latest News - New Lessons</h2>
        <div class="news-grid">
            @forelse($newsLessons as $lesson)
                <article class="news-card">
                    <div class="news-date">
                        <span class="day">{{ $lesson->created_at->format('d') }}</span>
                        <span class="month">{{ $lesson->created_at->format('M') }}</span>
                    </div>
                    <div class="news-content">
                        <h3>{{ $lesson->topic }}</h3>
                        <p class="news-meta">
                            <span class="news-group">{{ $lesson->group->name ?? 'No group' }}</span>
                            @if($lesson->teacher)
                                <span class="news-teacher">by {{ $lesson->teacher->name }}</span>
                            @endif
                        </p>
                        <p class="news-schedule">
                            @if($lesson->scheduled_at)
                                Scheduled: {{ $lesson->scheduled_at->format('M j, Y \a\t H:i') }}
                            @else
                                Not yet scheduled
                            @endif
                        </p>
                        <a href="{{ route('lessons.show', $lesson) }}" class="news-link">View lesson →</a>
                    </div>
                </article>
            @empty
                <p class="no-news">No lessons have been created yet. <a href="{{ route('lessons.create') }}">Create your
                        first lesson</a></p>
            @endforelse
        </div>
        @if($newsLessons->count() > 0)
            <div class="news-footer">
                <a href="{{ route('lessons.index') }}">View all lessons →</a>
            </div>
        @endif
    </div>

    <div class="dashboard-row">
        <div class="dashboard-section">
            <h2>Upcoming Lessons</h2>
            @forelse($recentLessons as $lesson)
                <div class="dashboard-item">
                    <strong>{{ $lesson->topic }}</strong>
                    <br>
                    <small>{{ $lesson->group->name ?? 'No group' }}
                        • {{ $lesson->scheduled_at ? $lesson->scheduled_at->format('M j, Y') : 'Not scheduled' }}</small>
                    <a href="{{ route('lessons.show', $lesson) }}">View</a>
                </div>
            @empty
                <p>No lessons yet.</p>
            @endforelse
            @if($recentLessons->count() > 0)
                <a href="{{ route('lessons.index') }}">View all lessons</a>
            @endif
        </div>

        <div class="dashboard-section">
            <h2>Top Students by Points</h2>
            @forelse($topStudents as $student)
                <div class="dashboard-item">
                    <strong>{{ $student->name }} {{ $student->last_name }}</strong>
                    <small>({{ $student->group->name ?? 'No group' }})</small>
                    <span class="points-badge">{{ $student->points ?? 0 }} pts</span>
                </div>
            @empty
                <p>No students yet.</p>
            @endforelse
            @if($topStudents->count() > 0)
                <a href="{{ route('students.index') }}">View all students</a>
            @endif
        </div>
    </div>
@endsection
