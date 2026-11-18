<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class ProjectController extends Controller
{
    /**
     * Display all projects.
     */
    public function index()
    {
        $projects = Project::with(['skills', 'category'])
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        $skills = Skill::with('category')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $projectCategories = ProjectCategory::orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.projects.index', compact(
            'projects',
            'skills',
            'projectCategories'
        ));
    }

    /**
     * Store a new project.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'nullable',
                'integer',
                'exists:project_categories,id',
            ],

            'title' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'live_url' => ['nullable', 'url', 'max:2048'],
            'repository_url' => ['nullable', 'url', 'max:2048'],

            'status' => [
                'sometimes',
                'required',
                Rule::in([
                    'in_progress',
                    'completed',
                    'on_hold',
                    'cancelled',
                ]),
            ],

            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],

            'skills' => ['nullable', 'array'],
            'skills.*' => [
                'integer',
                'distinct',
                'exists:skills,id',
            ],

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['title']
        );

        $validated['status'] = $validated['status'] ?? 'in_progress';

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        $selectedSkills = $validated['skills'] ?? [];

        unset($validated['skills']);

        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')
                ->store('projects', 'public');

            $validated['thumbnail'] = $thumbnailPath;
        }

        try {
            DB::transaction(function () use (
                $validated,
                $selectedSkills
            ) {
                $project = Project::create($validated);

                $project->skills()->sync($selectedSkills);
            });
        } catch (Throwable $exception) {
            if ($thumbnailPath) {
                Storage::disk('public')->delete($thumbnailPath);
            }

            throw $exception;
        }

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Proyek berhasil ditambahkan.');
    }

    /**
     * Update an existing project.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'category_id' => [
                'nullable',
                'integer',
                'exists:project_categories,id',
            ],

            'title' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'live_url' => ['nullable', 'url', 'max:2048'],
            'repository_url' => ['nullable', 'url', 'max:2048'],

            'status' => [
                'sometimes',
                'required',
                Rule::in([
                    'in_progress',
                    'completed',
                    'on_hold',
                    'cancelled',
                ]),
            ],

            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],

            'skills' => ['nullable', 'array'],
            'skills.*' => [
                'integer',
                'distinct',
                'exists:skills,id',
            ],

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['title'],
            $project->id
        );

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        $selectedSkills = $validated['skills'] ?? [];

        unset($validated['skills']);

        $oldThumbnailPath = $project->thumbnail;
        $newThumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $newThumbnailPath = $request->file('thumbnail')
                ->store('projects', 'public');

            $validated['thumbnail'] = $newThumbnailPath;
        } else {
            unset($validated['thumbnail']);
        }

        try {
            DB::transaction(function () use (
                $project,
                $validated,
                $selectedSkills
            ) {
                $project->update($validated);

                $project->skills()->sync($selectedSkills);
            });
        } catch (Throwable $exception) {
            if ($newThumbnailPath) {
                Storage::disk('public')->delete($newThumbnailPath);
            }

            throw $exception;
        }

        if ($newThumbnailPath && $oldThumbnailPath) {
            Storage::disk('public')->delete($oldThumbnailPath);
        }

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Proyek berhasil diperbarui.');
    }

    /**
     * Delete a project.
     */
    public function destroy(Project $project)
    {
        $thumbnailPath = $project->thumbnail;

        DB::transaction(function () use ($project) {
            $project->delete();
        });

        if ($thumbnailPath) {
            Storage::disk('public')->delete($thumbnailPath);
        }

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Proyek berhasil dihapus.');
    }

    /**
     * Generate a unique slug.
     */
    private function generateUniqueSlug(
        string $title,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($title) ?: 'project';
        $slug = $baseSlug;
        $counter = 2;

        while (
            Project::where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) => $query->where('id', '!=', $ignoreId)
                )
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
