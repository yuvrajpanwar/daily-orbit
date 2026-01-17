<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        // Very simple validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns|max:255|unique:subscribers,email',
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email'    => 'Please enter a valid email address.',
            'email.unique'   => 'This email is already subscribed to our newsletter.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('status', 'error')
                ->with('message', 'Please correct the errors below.');
        }

        try {
            Subscriber::create([
                'email'           => $request->email,
                'status'          => true,
                'subscribed_at'   => now(),
            ]);

            return back()
                ->with('status', 'success')
                ->with('success', 'Thank you! You have been successfully subscribed to our newsletter.');

        } catch (\Exception $e) {
            // In case of any unexpected error (very rare after validation)
            return back()
                ->with('status', 'error')
                ->with('error', 'Something went wrong. Please try again later.');
        }
    }
}