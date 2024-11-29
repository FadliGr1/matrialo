<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::latest()->take(5)->get();
        return view('manager.dashboard', compact('activities'));
    }

    public function store($userId, $activityType, $description)
    {
        $activity = new Activity();
        $activity->user_id = $userId;
        $activity->user_name = auth()->user()->name;
        $activity->activity_type = $activityType;
        $activity->description = $description;
        $activity->save();
    }

}
