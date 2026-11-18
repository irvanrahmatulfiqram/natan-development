<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::query()
            ->orderByDesc('start_date')
            ->get();

        return view('admin.educations.index', compact('educations'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateEducation($request);

        Education::create($validated);

        return redirect()
            ->route('admin.educations.index')
            ->with('success', 'Riwayat pendidikan berhasil ditambahkan.');
    }

    public function update(Request $request, Education $education)
    {
        $validated = $this->validateEducation($request);

        $education->update($validated);

        return redirect()
            ->route('admin.educations.index')
            ->with('success', 'Riwayat pendidikan berhasil diperbarui.');
    }

    public function destroy(Education $education)
    {
        $education->delete();

        return redirect()
            ->route('admin.educations.index')
            ->with('success', 'Riwayat pendidikan berhasil dihapus.');
    }

    private function validateEducation(Request $request): array
    {
        $validated = $request->validate([
            'degree' => [
                'required',
                'string',
                'max:100',
            ],
            'institution' => [
                'required',
                'string',
                'max:255',
            ],
            'field_of_study' => [
                'nullable',
                'string',
                'max:255',
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
                'required',
                'boolean',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ]);

        $validated['is_current'] = $request->boolean('is_current');
        $validated['is_active'] = $request->boolean('is_active');

        if ($validated['is_current']) {
            $validated['end_date'] = null;
        }

        return $validated;
    }
}
