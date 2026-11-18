<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::query()
            ->where('is_active', true)
            ->orderByDesc('start_date')
            ->get();

        return view('admin.experiences.index', compact('experiences'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateExperience($request);

        Experience::create($validated);

        return redirect()
            ->route('admin.experiences.index')
            ->with('success', 'Pengalaman kerja berhasil ditambahkan.');
    }

    public function update(Request $request, Experience $experience)
    {
        $validated = $this->validateExperience($request, $experience);

        $experience->update($validated);

        return redirect()
            ->route('admin.experiences.index')
            ->with('success', 'Pengalaman kerja berhasil diperbarui.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();

        return redirect()
            ->route('admin.experiences.index')
            ->with('success', 'Pengalaman kerja berhasil dihapus.');
    }

    private function validateExperience(
        Request $request,
        ?Experience $experience = null
    ): array {
        $validated = $request->validate([
            'job_title' => [
                'required',
                'string',
                'max:255',
            ],
            'company' => [
                'required',
                'string',
                'max:255',
            ],
            'employment_type' => [
                'required',
                Rule::in([
                    'full_time',
                    'part_time',
                    'freelance',
                    'internship',
                    'contract',
                    'self_employed',
                ]),
            ],
            'location' => [
                'nullable',
                'string',
                'max:255',
            ],
            'start_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
                'before_or_equal:today',
            ],
            'is_current' => [
                'nullable',
                'boolean',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        if ($request->boolean('is_current')) {
            $validated['end_date'] = null;
        }

        $validated['is_current'] = $request->boolean('is_current');
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
