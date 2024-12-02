<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Models\Project;

class ProjectStats extends Component
{
    public $totalProjects;
    public $latestProjects;

    public function __construct()
    {
        $this->totalProjects = Project::count();
        $this->latestProjects = Project::latest()
            ->take(5)
            ->get()
            ->map(function($project) {
                $words = explode(' ', $project->project_name);
                $initials = '';
                if (count($words) >= 2) {
                    $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                } else {
                    $initials = strtoupper(substr($project->project_name, 0, 2));
                }
                return [
                    'initials' => $initials,
                    'name' => $project->project_name
                ];
            });
    }

    public function render()
    {
        return view('components.project-stats');
    }
}
