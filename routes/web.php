<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Admin\SkillCategoryController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectCategoryController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\SettingController;


// Public Website
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/admin/login', [AuthController::class, 'login'])
        ->name('login.store');
});

// Protected Admin
Route::middleware('auth')->prefix('admin')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
    ->name('admin.dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('admin.profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('admin.profile.update');

    // Skill Categories
    Route::resource('skills-categories', SkillCategoryController::class)
        ->parameters([
            'skills-categories' => 'skillCategory',
        ])
        ->except(['show'])
        ->names('admin.skills-categories');

    // Skills
    Route::resource('skills', SkillController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.skills');

    // Projects
    Route::resource('projects', ProjectController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.projects');

    // Project Categories
    Route::resource('project-categories', ProjectCategoryController::class)
    ->parameters([
        'project-categories' => 'projectCategory',
    ])
    ->except(['show'])
    ->names('admin.project-categories');

    // Experiences
    Route::resource('experiences', ExperienceController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.experiences');

    // Educations
    Route::resource('educations', EducationController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.educations');

    // Website Settings
    Route::get('/settings', [SettingController::class, 'edit'])
        ->name('admin.settings.edit');

    Route::put('/settings', [SettingController::class, 'update'])
        ->name('admin.settings.update');
});


