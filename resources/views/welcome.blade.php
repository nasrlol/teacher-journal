@extends('layouts.guest')

@section('title', 'Welcome - Teacher Journal')

@section('content')
<h4>Welcome to Teacher Journal</h4>
<p>A simple tool for teachers to manage students, classes, and lessons.</p>
<a href="{{ route('dashboard') }}">Go to Dashboard</a>
@endsection

