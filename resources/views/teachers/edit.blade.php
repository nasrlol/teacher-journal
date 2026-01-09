@extends('layouts.app')

@section('title', 'Edit Teacher - Teacher Journal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/teachers.css') }}">
@endpush

@section('content')
<a href="{{ route('teachers.index') }}">Back to Teachers</a>

<h5>Edit Teacher</h5>

<form action="{{ route('teachers.update', $teacher) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="name">First Name</label>
    <input type="text" name="name" id="name" required value="{{ $teacher->name }}">

    <label for="last_name">Last Name</label>
    <input type="text" name="last_name" id="last_name" required value="{{ $teacher->last_name }}">

    <label for="email">Email</label>
    <input type="email" name="email" id="email" required value="{{ $teacher->email }}">

    <label for="password">Password</label>
    <input type="password" name="password" id="password" minlength="8" placeholder="Leave blank to keep current password">
    <small>Only fill in password if you want to change it.</small>

    <button type="submit">Update Teacher</button>
    <a href="{{ route('teachers.index') }}">Cancel</a>
</form>
@endsection
