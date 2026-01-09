<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    /**
     * Show the FAQ page.
     */
    public function faq()
    {
        return view('pages.faq');
    }

    /**
     * Show the contact page.
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Handle contact form submission.
     */
    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        try {
            Mail::raw(
                "New contact message from {$validated['name']} ({$validated['email']})\n\n" .
                "Subject: {$validated['subject']}\n\n" .
                "Message:\n{$validated['message']}",
                function ($mail) use ($validated) {
                    $mail->to('abdellah.el.morabit@student.ehb.be')
                        ->subject('Contact Form: ' . $validated['subject']);
                }
            );
        } catch (Exception $e) {
            Log::error('Failed to send contact email: ' . $e->getMessage());
        }

        return redirect()->route('contact')->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    /**
     * Show the home/welcome page.
     */
    public function home()
    {
        return redirect()->route('login');
    }

    /**
     * Show the app page.
     */
    public function app()
    {
        return view('app');
    }
}

