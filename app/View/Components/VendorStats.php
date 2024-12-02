<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Models\Vendor;

class VendorStats extends Component
{
    public $totalVendors;
    public $latestVendors;

    public function __construct()
    {
        $this->totalVendors = Vendor::count();
        $this->latestVendors = Vendor::latest()
            ->take(5)
            ->get()
            ->map(function($vendor) {
                $words = explode(' ', $vendor->vendor_name);
                $initials = '';
                if (count($words) >= 2) {
                    $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                } else {
                    $initials = strtoupper(substr($vendor->vendor_name, 0, 2));
                }
                return [
                    'initials' => $initials,
                    'name' => $vendor->vendor_name
                ];
            });
    }

    public function render()
    {
        return view('components.vendor-stats');
    }
}
