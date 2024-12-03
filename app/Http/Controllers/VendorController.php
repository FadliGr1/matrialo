<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function dashboard() {
        return view ('vendor.dashboard');
    }

    public function materials () {
        return view ('vendor.materials');
    }

    public function dorelease () {
        return view ('vendor.dorelease');
    }
}
