<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkillCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SkillCategoryController extends Controller
{
    public function index()
    {
        $categories = SkillCategory::withCount('skills')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.skills.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.skills.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        SkillCategory::create($validated);

        return redirect()
            ->route('admin.skills-categories.index')
            ->with('success', 'Kategori skill berhasil ditambahkan.');
    }

    public function edit(SkillCategory $skillCategory)
    {
        return view('admin.skills.categories.edit', compact('skillCategory'));
    }

    public function update(Request $request, SkillCategory $skillCategory)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        $skillCategory->update($validated);

        return redirect()
            ->route('admin.skills-categories.index')
            ->with('success', 'Kategori skill berhasil diperbarui.');
    }

    public function destroy(SkillCategory $skillCategory)
    {
        $skillCategory->delete();

        return redirect()
            ->route('admin.skills-categories.index')
            ->with('success', 'Kategori skill berhasil dihapus.');
    }
}
