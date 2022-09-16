<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Following;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowingController extends Controller
{
    
    public function follow(Request $request) 
    {
        $user_id = Auth::id();
        $user = Auth::user();
        $following_id = $request->id;
        
        $following = User::find($following_id);
    
        Following::firstOrCreate([
            'user_id' => $user_id,
            'following_id' => $following_id,
        ]);

        Activity::create([
            'activity' => $user->first_name . ' followed ' . $following->first_name,
            'activitiable_id' => $user_id,
            'activitiable_type' => 'App\Models\Following'
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
        $user = Auth::user();

        $following = Following::where('following_id', $request->id)->first();
        
        $following_user = User::find($request->id);
        if (!$following) {
            return response()->json('Currently not following user');
        }

        $following->delete();

        Activity::create([
            'activity' => $user->first_name . ' unfollowed ' . $following_user->first_name,
            'activitiable_id' => $user->id,
            'activitiable_type' => 'App\Models\Following'
        ]);

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
