@extends('layouts.guest')
@endsection
</div>
</div>
<a href="{{ route('contact') }}">Contact Us →</a>
<a href="{{ route('login') }}">← Back to Login</a>
<div class="page-links">

</div>
</div>
<p>Please visit our <a href="{{ route('contact') }}">Contact page</a> to send us a message.</p>
<h4>I have another question. How can I contact support?</h4>
<div class="faq-item">

</div>
<p>Currently, data export is not available. This feature may be added in future updates.</p>
<h4>Can I export my data?</h4>
<div class="faq-item">

</div>
<p>Yes, all data is stored securely and only accessible to logged-in users. Each teacher can only see their own
    data.</p>
<h4>Is my data secure?</h4>
<div class="faq-item">

    <h3>Other Questions</h3>
    <div class="faq-section">

    </div>
</div>
<p>Yes, the student profile shows their attendance history, activity scores, and point history.</p>
<h4>Can I see a student's history?</h4>
<div class="faq-item">

</div>
<p>Open a student's profile and use the "Add Points" feature. You can add or subtract points for participation, good
    behavior, or other criteria.</p>
<h4>How do I add points to a student?</h4>
<div class="faq-item">

</div>
<p>Go to "Students" and click "Create Student". Enter the student's name, email (optional), and assign them to a
    group.</p>
<h4>How do I add a new student?</h4>
<div class="faq-item">

    <h3>Managing Students</h3>
    <div class="faq-section">

    </div>
</div>
<p>Open the activity and click "Record Scores". Enter the score for each student and save. The system will calculate
    percentages automatically.</p>
<h4>How do I record scores for an activity?</h4>
<div class="faq-item">

</div>
<p>Go to "Activities" and click "Create Activity". Enter the activity name, description, maximum score, and select the
    associated group or lesson.</p>
<h4>How do I create an activity?</h4>
<div class="faq-item">

</div>
<p>Activities are assignments, tests, or projects that you can create to track student performance. Each activity can
    have scores assigned to students.</p>
<h4>What are activities?</h4>
<div class="faq-item">

    <h3>Managing Activities & Grades</h3>
    <div class="faq-section">

    </div>
</div>
<p>Yes, when creating or editing a lesson, you can add notes or a description to keep track of what was covered.</p>
<h4>Can I add notes to a lesson?</h4>
<div class="faq-item">

</div>
<p>Open a lesson and click "Record Attendance". You can mark each student as present, absent, or late. Save your changes
    when done.</p>
<h4>How do I record attendance?</h4>
<div class="faq-item">

</div>
<p>Go to "Lessons" and click "Create Lesson". Select the group, enter the lesson details (date, topic), and save.</p>
<h4>How do I create a lesson?</h4>
<div class="faq-item">

    <h3>Managing Lessons</h3>
    <div class="faq-section">

    </div>
</div>
<p>Go to the "Students" section, create or edit a student, and select the group they belong to from the dropdown
    menu.</p>
<h4>How do I assign students to a group?</h4>
<div class="faq-item">

</div>
<p>Sub-groups allow you to divide a main group into smaller sections. This is useful for practical sessions or group
    work where you need to split students.</p>
<h4>What are sub-groups?</h4>
<div class="faq-item">

</div>
<p>Navigate to "Groups" in the menu and click "Create Group". Enter a name for your group and save. You can then add
    students to this group.</p>
<h4>How do I create a new group?</h4>
<div class="faq-item">

    <h3>Managing Groups</h3>
    <div class="faq-section">

    </div>
</div>
<p>On the login page, click "Forgot Password" and enter your email address. You will receive an email with instructions
    to reset your password.</p>
<h4>I forgot my password. What should I do?</h4>
<div class="faq-item">

</div>
<p>Click on the "Register" link on the login page. Fill in your name, email address, and choose a password. After
    registration, you can log in and start using the application.</p>
<h4>How do I create an account?</h4>
<div class="faq-item">

</div>
<p>Teacher Journal is an application designed for teachers to manage their classes, students, lessons, and activities.
    It helps you keep track of attendance, grades, and student performance.</p>
<h4>What is Teacher Journal?</h4>
<div class="faq-item">

    <h3>Getting Started</h3>
    <div class="faq-section">

        <p>Learn how to use the Teacher Journal application.</p>
        <h2>Frequently Asked Questions</h2>
        <div class="page-container">
            @section('content')

                @endpush
                <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
@push('styles')

    @section('title', 'FAQ - Teacher Journal')


