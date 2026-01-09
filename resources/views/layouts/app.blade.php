<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Teacher Journal')</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts.css') }}">
    @stack('styles')
</head>

<body>
<nav>
    <a href="{{ route('dashboard') }}">Teacher Journal</a>
    <ul>
        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('teachers.index') }}">Teachers</a></li>
        <li><a href="{{ route('groups.index') }}">Groups</a></li>
        <li><a href="{{ route('sub-groups.index') }}">Sub Groups</a></li>
        <li><a href="{{ route('students.index') }}">Students</a></li>
        <li><a href="{{ route('lessons.index') }}">Lessons</a></li>
        <li><a href="{{ route('activities.index') }}">Activities</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </li>
    </ul>
</nav>

<main>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p>{{ session('error') }}</p>
    @endif

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @yield('content')
</main>

@stack('scripts')
</body>

</html>

