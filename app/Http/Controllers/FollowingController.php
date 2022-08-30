<?php

namespace App\Http\Controllers;

use App\Models\Following;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowingController extends Controller
{
    public function follow(Request $request) 
    {
        $user_id = $request->user()->id;
        $following_id = $request->id;

        Following::firstOrCreate([
            'user_id' => $user_id,
            'following_id' => $following_id,
        ]);

        $data = [
            'message' => 'Followed new user!',
            'user_id' => $user_id,
            'following_id' => $following_id,
        ];

        return response()->json($data);
    }

    public function followings(Request $request)
    {
        $user = $request->user();

        $followings = Following::where('user_id', $user->id)->get();
        $followingsCount = $followings->count();
        $data = [
            'user' => $user,
            'followings' => $followingsCount,
        ];

        return response()->json($data);
    }

    public function followers(Request $request)
    {
        $user = Auth::user();
        $userId = Auth::id();
        $followers = Following::where('following_id', $userId)->get();
        $followersCount = $followers->count();
        
        $data = [
            'user' => $user,
            'user_id' => $userId,
            'followers' => $followersCount
        ];
        return response()->json($data);
    }
}
