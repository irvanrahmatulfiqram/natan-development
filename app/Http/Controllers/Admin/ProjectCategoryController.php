<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectCategoryController extends Controller
{
    /**
     * Display all project categories.
     */
    public function index()
    {
        $categories = ProjectCategory::withCount('projects')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.projects.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a category.
     */
    public function create()
    {
        return view('admin.projects.categories.create');
    }

    /**
     * Store a new category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:project_categories,name',
            ],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['name']
        );

        $validated['is_active'] = $request->boolean('is_active');

        ProjectCategory::create($validated);

        return redirect()
            ->route('admin.project-categories.index')
            ->with('success', 'Kategori proyek berhasil ditambahkan.');
    }

    /**
     * Show the form for editing a category.
     */
    public function edit(ProjectCategory $projectCategory)
    {
        return view(
            'admin.projects.categories.edit',
            compact('projectCategory')
        );
    }

    /**
     * Update an existing category.
     */
    public function update(
        Request $request,
        ProjectCategory $projectCategory
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('project_categories', 'name')
                    ->ignore($projectCategory->id),
            ],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['name'],
            $projectCategory->id
        );

        $validated['is_active'] = $request->boolean('is_active');

        $projectCategory->update($validated);

        return redirect()
            ->route('admin.project-categories.index')
            ->with('success', 'Kategori proyek berhasil diperbarui.');
    }

    /**
     * Delete a category.
     */
    public function destroy(ProjectCategory $projectCategory)
    {
        $projectCategory->delete();

        return redirect()
            ->route('admin.project-categories.index')
            ->with('success', 'Kategori proyek berhasil dihapus.');
    }

    /**
     * Generate a unique category slug.
     */
    private function generateUniqueSlug(
        string $name,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($name) ?: 'category';
        $slug = $baseSlug;
        $counter = 2;

        while (
            ProjectCategory::where('slug', $slug)
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
