<?php

namespace App\Http\Controllers;

use App\Models\Following;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowingController extends Controller
{
    
    public function follow(Request $request) 
    {
        $user_id = Auth::id();
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

    public function isFollowing(Request $request)
    {
        $user_id = Auth::id();
        $isFollowing = !!Following::where('user_id', $user_id)
            ->where('following_id', $request->id)->count();

        return response()->json($isFollowing);
    }
    
    public function unfollow(Request $request) 
    {
        $id = $request->id;
        $follow = Following::where('following_id', $id)->first();

        if (!$follow) {
            return response()->json('Currently not following user');
        }

        $follow->delete();

        return response()->json('Unfollowed user!');
    }

    public function followings(Request $request)
    {
        $id = $request->id;

        $followings = Following::where('user_id', $id)->get();
        $followingsCount = $followings->count();
        $data = [
            'followings' => $followingsCount,
        ];

        return response()->json($data);
    }

    public function followers(Request $request)
    {
        $id = $request->id;

        $followers = Following::where('following_id', $id)->get();
        $followersCount = $followers->count();
        
        $data = [
            'followers' => $followersCount
        ];
        return response()->json($data);
    }
}
