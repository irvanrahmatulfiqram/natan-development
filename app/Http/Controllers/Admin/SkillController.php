<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::with('category')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $categories = SkillCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.skills.index', compact(
            'skills',
            'categories'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'skill_category_id' => [
                'required',
                'integer',
                'exists:skill_categories,id',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'icon' => [
                'nullable',
                'string',
                'max:255',
            ],
            'proficiency_level' => [
                'nullable',
                Rule::in([
                    'Beginner',
                    'Intermediate',
                    'Advanced',
                    'Expert',
                ]),
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'is_featured' => [
                'nullable',
                'boolean',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        Skill::create($validated);

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Skill berhasil ditambahkan.');
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'skill_category_id' => [
                'required',
                'integer',
                'exists:skill_categories,id',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'icon' => [
                'nullable',
                'string',
                'max:255',
            ],
            'proficiency_level' => [
                'nullable',
                Rule::in([
                    'Beginner',
                    'Intermediate',
                    'Advanced',
                    'Expert',
                ]),
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'is_featured' => [
                'nullable',
                'boolean',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        $skill->update($validated);

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Skill berhasil diperbarui.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Skill berhasil dihapus.');
    }
}
