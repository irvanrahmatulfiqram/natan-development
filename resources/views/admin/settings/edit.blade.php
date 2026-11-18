
@extends('layouts.admin')

@section('title', 'Website Settings')
@section('page-title', 'Website Settings')
@section('page-description', 'Kelola identitas dan tampilan website Anda.')

@section('content')

    <form
        action="{{ route('admin.settings.update') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        {{-- PAGE HEADER --}}
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="font-heading text-xl font-bold text-slate-900">
                    Website Identity
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Kelola nama website, logo, dan identitas visual.
                </p>
            </div>

            <button
                type="submit"
                class="rounded-xl bg-amber-400 px-6 py-3 text-sm font-bold text-slate-900 transition hover:bg-amber-300"
            >
                Save Changes →
            </button>
        </div>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- VALIDATION ERRORS --}}
        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p class="mb-2 font-semibold">
                    Terdapat kesalahan pada pengisian form:
                </p>

                <ul class="list-inside list-disc space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- GENERAL INFORMATION --}}
        <section class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="mb-6">
                <h4 class="font-heading text-lg font-bold text-slate-900">
                    General Information
                </h4>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi dasar identitas website.
                </p>
            </div>

            <div class="grid gap-6">

                {{-- WEBSITE NAME --}}
                <div>
                    <label for="site-name" class="mb-2 block text-sm font-semibold text-slate-700">
                        Website Name *
                    </label>

                    <input
                        type="text"
                        name="site_name"
                        id="site-name"
                        value="{{ old('site_name', $setting->site_name) }}"
                        required
                        maxlength="255"
                        placeholder="Natan Development"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"
                    >

                    @error('site_name')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- WEBSITE DESCRIPTION --}}
                <div>
                    <label for="site-description" class="mb-2 block text-sm font-semibold text-slate-700">
                        Website Description
                    </label>

                    <textarea
                        name="site_description"
                        id="site-description"
                        rows="3"
                        placeholder="Deskripsi singkat website..."
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"
                    >{{ old('site_description', $setting->site_description) }}</textarea>

                    @error('site_description')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </section>

        {{-- WEBSITE LOGO --}}
        <section class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="mb-6">
                <h4 class="font-heading text-lg font-bold text-slate-900">
                    Website Logo
                </h4>

                <p class="mt-1 text-sm text-slate-500">
                    Logo yang digunakan pada Navbar website dan Sidebar Admin.
                </p>
            </div>

            <div class="grid items-start gap-8 md:grid-cols-2">

                {{-- LOGO PREVIEW --}}
                <div>
                    <label class="mb-3 block text-sm font-semibold text-slate-700">
                        Logo Preview
                    </label>

                    <div class="flex min-h-36 items-center justify-center rounded-xl border border-dashed border-slate-300 bg-slate-50 p-6">

                        <div
                            id="site-logo-placeholder"
                            class="{{ $setting->site_logo ? 'hidden' : '' }} flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-900 font-heading text-3xl font-bold text-white"
                        >
                            N
                        </div>

                        <img
                            id="site-logo-preview"
                            src="{{ $setting->site_logo ? asset('storage/' . $setting->site_logo) : '' }}"
                            alt="Website Logo Preview"
                            class="{{ $setting->site_logo ? '' : 'hidden' }} max-h-24 max-w-full object-contain"
                        >

                    </div>
                </div>

                {{-- LOGO UPLOAD --}}
                <div>
                    <label for="site-logo" class="mb-3 block text-sm font-semibold text-slate-700">
                        Upload New Logo
                    </label>

                    <input
                        type="file"
                        name="site_logo"
                        id="site-logo"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        class="block w-full text-sm text-slate-600 file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-amber-100 file:px-4 file:py-2 file:font-semibold file:text-amber-800 hover:file:bg-amber-200"
                    >

                    <p class="mt-3 text-xs leading-6 text-slate-400">
                        Format JPG, JPEG, PNG, atau WebP. Maksimal 2 MB.
                    </p>

                    <p class="mt-2 text-xs text-slate-400">
                        Disarankan menggunakan gambar persegi atau horizontal dengan background transparan.
                    </p>

                    @error('site_logo')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </section>

        {{-- WEBSITE FAVICON --}}
        <section class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="mb-6">
                <h4 class="font-heading text-lg font-bold text-slate-900">
                    Website Favicon
                </h4>

                <p class="mt-1 text-sm text-slate-500">
                    Ikon kecil yang ditampilkan pada tab browser.
                </p>
            </div>

            <div class="grid items-start gap-8 md:grid-cols-2">

                {{-- FAVICON PREVIEW --}}
                <div>
                    <label class="mb-3 block text-sm font-semibold text-slate-700">
                        Favicon Preview
                    </label>

                    <div class="flex min-h-36 items-center justify-center rounded-xl border border-dashed border-slate-300 bg-slate-50 p-6">

                        <div
                            id="site-favicon-placeholder"
                            class="{{ $setting->site_favicon ? 'hidden' : '' }} flex h-16 w-16 items-center justify-center rounded-xl bg-slate-900 font-heading text-3xl font-bold text-white"
                        >
                            N
                        </div>

                        <img
                            id="site-favicon-preview"
                            src="{{ $setting->site_favicon ? asset('storage/' . $setting->site_favicon) : '' }}"
                            alt="Favicon Preview"
                            class="{{ $setting->site_favicon ? '' : 'hidden' }} h-16 w-16 object-contain"
                        >

                    </div>
                </div>

                {{-- FAVICON UPLOAD --}}
                <div>
                    <label for="site-favicon" class="mb-3 block text-sm font-semibold text-slate-700">
                        Upload New Favicon
                    </label>

                    <input
                        type="file"
                        name="site_favicon"
                        id="site-favicon"
                        accept=".ico,.png,.jpg,.jpeg,.webp,image/x-icon,image/png,image/jpeg,image/webp"
                        class="block w-full text-sm text-slate-600 file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-amber-100 file:px-4 file:py-2 file:font-semibold file:text-amber-800 hover:file:bg-amber-200"
                    >

                    <p class="mt-3 text-xs leading-6 text-slate-400">
                        Format ICO, PNG, JPG, atau WebP. Maksimal 512 KB.
                    </p>

                    <p class="mt-2 text-xs text-slate-400">
                        Disarankan menggunakan ukuran 32 × 32 atau 64 × 64 piksel.
                    </p>

                    @error('site_favicon')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </section>

        {{-- BOTTOM ACTION --}}
        <div class="flex justify-end">
            <button
                type="submit"
                class="rounded-xl bg-amber-400 px-6 py-3 text-sm font-bold text-slate-900 transition hover:bg-amber-300"
            >
                Save Changes →
            </button>
        </div>

    </form>

@endsection
