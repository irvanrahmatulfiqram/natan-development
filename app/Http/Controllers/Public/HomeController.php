<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillCategory;

class HomeController extends Controller
{
    public function index()
    {
        $profile = Profile::first();

        $skillCategories = SkillCategory::query()
            ->where('is_active', true)
            ->whereHas('skills', function ($query) {
                $query->where('is_active', true);
            })
            ->with([
                'skills' => function ($query) {
                    $query->where('is_active', true)
                        ->orderBy('sort_order')
                        ->orderBy('name');
                },
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Professional Experience
        $experiences = Experience::query()
            ->where('is_active', true)
            ->orderByDesc('start_date')
            ->get();

        // Education
        $educations = Education::query()
            ->where('is_active', true)
            ->orderByDesc('start_date')
            ->get();

        // Project yang sedang dikerjakan
        $currentlyWorkingProjects = Project::query()
            ->where('is_active', true)
            ->where('status', 'in_progress')
            ->with([
                'category',
                'skills' => function ($query) {
                    $query->where('is_active', true)
                        ->orderBy('sort_order')
                        ->orderBy('name');
                },
            ])
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        // Project selesai yang dipilih sebagai Featured
        $featuredProjects = Project::query()
            ->where('is_active', true)
            ->where('status', 'completed')
            ->where('is_featured', true)
            ->with([
                'category',
                'skills' => function ($query) {
                    $query->where('is_active', true)
                        ->orderBy('sort_order')
                        ->orderBy('name');
                },
            ])
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('public.home', compact(
            'profile',
            'skillCategories',
            'experiences',
            'educations',
            'currentlyWorkingProjects',
            'featuredProjects'
        ));
    }
}
