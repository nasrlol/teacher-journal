@extends('layouts.guest')

@section('title', 'Contact - Teacher Journal')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
@endpush

@section('content')
    <div class="page-container">
        <h2>Contact Us</h2>
        <p>Have questions or feedback? We'd love to hear from you!</p>

        <div class="contact-info">
            <h3>Get in Touch</h3>
            <p><strong>Email:</strong> <a href="mailto:abdellah.el.morabit@student.ehb.be">abdellah.el.morabit@student.ehb.be</a>
            </p>
        </div>

        <div class="contact-form-section">
            <h3>Send a Message</h3>

            <form method="POST" action="{{ route('contact.send') }}">
                @csrf

                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required minlength="2"
                       maxlength="255">

                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>

                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required minlength="3"
                       maxlength="255">

                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required minlength="10"
                          maxlength="5000">{{ old('message') }}</textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>

        <div class="page-links">
            <a href="{{ route('login') }}">← Back to Login</a>
            <a href="{{ route('faq') }}">FAQ →</a>
        </div>
    </div>
@endsection

