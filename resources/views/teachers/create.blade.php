@extends('layouts.app')

@section('title', 'Add Teacher - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/teachers.css') }}">
@endpush

@section('content')
<a href="{{ route('teachers.index') }}">Back to Teachers</a>

<h5>Add New Teacher</h5>

<form action="{{ route('teachers.store') }}" method="POST">
    @csrf

    <label for="name">First Name</label>
    <input type="text" name="name" id="name" required placeholder="Enter first name">

    <label for="last_name">Last Name</label>
    <input type="text" name="last_name" id="last_name" required placeholder="Enter last name">

    <label for="email">Email</label>
    <input type="email" name="email" id="email" required placeholder="Enter email address">

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required minlength="8" placeholder="Minimum 8 characters">

    <button type="submit">Save Teacher</button>
    <a href="{{ route('teachers.index') }}">Cancel</a>
</form>
@endsection
