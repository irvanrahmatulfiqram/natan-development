<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Skill;
use App\Models\SkillCategory;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $statistics = [
            [
                'label' => 'Total Projects',
                'value' => Project::count(),
                'description' => 'All registered projects',
            ],
            [
                'label' => 'Total Skills',
                'value' => Skill::count(),
                'description' => 'All registered skills',
            ],
            [
                'label' => 'Experiences',
                'value' => Experience::count(),
                'description' => 'Professional experiences',
            ],
            [
                'label' => 'Education',
                'value' => Education::count(),
                'description' => 'Education records',
            ],
            [
                'label' => 'Project Categories',
                'value' => ProjectCategory::count(),
                'description' => 'Available project categories',
            ],
            [
                'label' => 'Skill Categories',
                'value' => SkillCategory::count(),
                'description' => 'Available skill categories',
            ],
        ];

        // Statistik status project
        $projectStatus = [
            'in_progress' => Project::where('status', 'in_progress')->count(),
            'completed' => Project::where('status', 'completed')->count(),
            'on_hold' => Project::where('status', 'on_hold')->count(),
            'cancelled' => Project::where('status', 'cancelled')->count(),
        ];

        // Lima project terbaru
        $recentProjects = Project::query()
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        // Lima pengalaman kerja terbaru
        $recentExperiences = Experience::query()
            ->orderByDesc('start_date')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'statistics',
            'projectStatus',
            'recentProjects',
            'recentExperiences'
        ));
    }
}
