<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Models\User;

class UserStats extends Component
{
    public $totalUsers;
    public $latestUsers;

    public function __construct()
    {
        $this->totalUsers = User::count();
        $this->latestUsers = User::latest()
            ->take(5)
            ->get()
            ->map(function($user) {
                return [
                    'name' => $user->name,
                    'photo' => $user->profile_photo_path 
                        ? asset('storage/' . $user->profile_photo_path)
                        : asset('img/default-avatar.png')
                ];
            });
    }

    public function render()
    {
        return view('components.user-stats');
    }
}