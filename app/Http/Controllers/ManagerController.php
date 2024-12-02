<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;


class ManagerController extends Controller
{
    public function dashboard() {
        return view ('manager.dashboard');
    }

    public function user () {
        return view ('manager.user');
    }

    public function vendor () {
        return view ('manager.vendor');
    }

    public function warehouse () {
        return view ('manager.warehouse');
    }

    public function project () {
        return view ('manager.project');
    }
    
}
