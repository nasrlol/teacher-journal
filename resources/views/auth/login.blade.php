<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Teacher Journal</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
<div class="auth-container">
    <h1>Login</h1>

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <div class="remember-me">
            <input type="checkbox" id="remember" name="remember" value="1">
            <label for="remember">Remember me</label>
        </div>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
    <p><a href="{{ route('faq') }}">FAQ</a> | <a href="{{ route('contact') }}">Contact</a></p>
</div>
</body>
</html>

