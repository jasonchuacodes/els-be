<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function fetchUserActivities(Request $request)
    {   
        $user_id = $request->user_id;

        $activities =  Activity::where('activitiable_id', $user_id)
        ->latest()
        ->take(5)
        ->get();

        return response()->json($activities);
    }
    public function fetchAllUsersActivities(Request $request)
    {   

        $activities =  Activity::take(10)->latest()->get();

        return response()->json($activities);
    }
}
