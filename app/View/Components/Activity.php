<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use App\Models\Activity as ActivityModel;

class Activity extends Component
{
    public $activities;

    public function __construct()
    {
        $this->activities = ActivityModel::latest()->get();
    }

    public function render()
    {
        return view('components.activity');
    }
}

