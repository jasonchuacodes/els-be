<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function resend(Request $request)
    {
        $validated = $request->only([
            'email'
        ]);

        $user = User::where('email', $validated['email'])->first();
        
        if (!$user) 
        {
            return response()->json('Email does not exist. Please try again.');
        }
        
        $user->sendEmailVerificationNotification();

        return response()->json('Verification link sent!', 200);
    }

    public function verify(Request $request)
    {
        $user = User::findOrFail($request->id);

        if ($user->hasVerifiedEmail()) {
            return response()->json('Already verified! yehey');
        }

        if (!$request->hasValidSignature()) {
            return response()->json('Invalid or expired signature. Please request for a new verification link.');
        }

        $user->markEmailAsVerified();
        
        $data = [
            'message' => 'Thank you for verifying your email!',
        ];

        return response()->json($data['message']);
    }
}
