<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Journal') - Teacher Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body>
    <nav class="main-nav">
        <a href="{{ route('dashboard') }}" class="nav-brand">Teacher Journal</a>
        <ul class="nav-links">
            <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ route('teachers.index') }}" class="{{ request()->routeIs('teachers.*') ? 'active' : '' }}">Teachers</a></li>
            <li><a href="{{ route('groups.index') }}" class="{{ request()->routeIs('groups.*') ? 'active' : '' }}">Classes</a></li>
            <li><a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">Students</a></li>
            <li><a href="{{ route('lessons.index') }}" class="{{ request()->routeIs('lessons.*') ? 'active' : '' }}">Lessons</a></li>
            <li><a href="{{ route('activities.index') }}" class="{{ request()->routeIs('activities.*') ? 'active' : '' }}">Activities</a></li>
        </ul>
    </nav>

    <main class="main-content">
        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if(session('error') || $errors->any())
            <div class="alert error">
                {{ session('error') }}
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="main-footer">
        <p>Teacher Journal &copy; {{ date('Y') }}</p>
    </footer>
</body>
</html>