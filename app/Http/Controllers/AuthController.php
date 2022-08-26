<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        event(new Registered($user));

        return response()->json('Success! Please verify registration by clicking on the link we sent to your email.', 200);
    }

    public function login(Request $request) 
    {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // MANUAL METHOD
        $user = User::where('email', $request->email)->first();
        
        if(!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json('Invalid user credentials. Please try again', 403);
        } else {

            $token = $user->createToken('els_token')->plainTextToken;
            $id = $user->id;

            $data = [
                'message' => 'Successfully logged in user.',
                'user' => $user,
                'id' => $id,
                'token' => $token,
            ];

            return response()->json($data);
        }

        // SHORTCUT METHOD - with Auth facade
        // if (Auth::attempt($validated))
        // {
        //     $user = Auth::user();
        //     $id = Auth::id();

        //     $token = $user->createToken('els_token')->plainTextToken;

        //     $data = [
        //         'message' => 'Successfully logged in',
        //         'user' => $user,
        //         'id' => $id,
        //         'token' => $token,
        //     ];

        //     return response()->json($data);
        // } 
        // else 
        // {
        //     return response()->json('Whoops! Incorrect email or password', 403);
        // }
    }

    public function logout() 
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return response()->json('Logged out user');
    }
}
