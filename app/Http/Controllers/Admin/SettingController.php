<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::current();

        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_description' => ['nullable', 'string'],

            'site_logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'site_favicon' => [
                'nullable',
                'file',
                'mimes:ico,png,jpg,jpeg,webp',
                'max:512',
            ],
        ]);

        $setting = Setting::current();

        // Upload logo baru.
        if ($request->hasFile('site_logo')) {
            $newLogoPath = $request->file('site_logo')
                ->store('settings', 'public');

            $oldLogoPath = $setting->site_logo;

            $validated['site_logo'] = $newLogoPath;

            if ($oldLogoPath) {
                Storage::disk('public')->delete($oldLogoPath);
            }
        }

        // Upload favicon baru.
        if ($request->hasFile('site_favicon')) {
            $newFaviconPath = $request->file('site_favicon')
                ->store('settings', 'public');

            $oldFaviconPath = $setting->site_favicon;

            $validated['site_favicon'] = $newFaviconPath;

            if ($oldFaviconPath) {
                Storage::disk('public')->delete($oldFaviconPath);
            }
        }

        $setting->update($validated);

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'Website settings berhasil diperbarui.');
    }
}
