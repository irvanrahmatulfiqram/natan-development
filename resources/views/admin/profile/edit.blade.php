@extends('layouts.admin')

@section('title', 'Profile Management')
@section('page-title', 'Profile Management')
@section('page-description', 'Kelola identitas profesional dan profil publik Anda.')

@section('content')

<form action="{{ route('admin.profile.update') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    {{-- Page Header --}}
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h3 class="font-heading text-xl font-bold text-slate-900">
                Edit Profile
            </h3>
            <p class="mt-1 text-sm text-slate-500">
                Informasi yang akan ditampilkan pada website publik.
            </p>
        </div>

        <button type="submit"
            class="rounded-xl bg-amber-400 px-6 py-3 text-sm font-bold text-slate-900 transition hover:bg-amber-300">
            Save Changes
        </button>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation Errors --}}
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

    {{-- Professional Identity --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <div class="mb-6">
            <h4 class="font-heading text-lg font-bold text-slate-900">
                Professional Identity
            </h4>
            <p class="mt-1 text-sm text-slate-500">
                Informasi identitas dan pengenalan profesional Anda.
            </p>
        </div>

        {{-- Profile Photo --}}
        <div class="mb-8 flex flex-wrap items-center gap-5">

            <div class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 bg-slate-100">

                <div id="photo-placeholder"
                    class="{{ $profile?->photo ? 'hidden' : '' }} flex h-full w-full items-center justify-center text-3xl font-bold text-slate-400">
                    {{ strtoupper(substr($profile?->name ?? 'N', 0, 1)) }}
                </div>

                <img
                    id="photo-preview"
                    src="{{ $profile?->photo ? asset('storage/' . $profile->photo) : '' }}"
                    alt="Profile Photo"
                    class="{{ $profile?->photo ? '' : 'hidden' }} h-full w-full object-cover"
                >

            </div>

            <div class="min-w-0 flex-1">
                <label for="photo-input"
                    class="mb-2 block text-sm font-semibold text-slate-700">
                    Profile Photo
                </label>

                <input
                    type="file"
                    name="photo"
                    id="photo-input"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="block w-full max-w-md text-sm text-slate-600 file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-amber-100 file:px-4 file:py-2 file:font-semibold file:text-amber-800 hover:file:bg-amber-200"
                >

                <p class="mt-2 text-xs text-slate-400">
                    Format JPG, JPEG, PNG, atau WebP. Maksimal 2 MB.
                </p>

                @error('photo')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="mb-6 border-t border-slate-100"></div>

        {{-- Identity Fields --}}
        <div class="grid gap-6 md:grid-cols-2">

            <div class="md:col-span-2">
                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
                    Professional Name *
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $profile?->name) }}"
                    required
                    placeholder="Nama profesional Anda"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"
                >
            </div>

            <div>
                <label for="professional_title" class="mb-2 block text-sm font-semibold text-slate-700">
                    Professional Title *
                </label>

                <input
                    type="text"
                    name="professional_title"
                    id="professional_title"
                    value="{{ old('professional_title', $profile?->professional_title) }}"
                    required
                    placeholder="Full Stack Web Developer"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"
                >
            </div>

            <div>
                <label for="tagline" class="mb-2 block text-sm font-semibold text-slate-700">
                    Tagline
                </label>

                <input
                    type="text"
                    name="tagline"
                    id="tagline"
                    value="{{ old('tagline', $profile?->tagline) }}"
                    placeholder="Membangun Solusi Digital untuk Kebutuhan Bisnis"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"
                >
            </div>

            <div class="md:col-span-2">
                <label for="location" class="mb-2 block text-sm font-semibold text-slate-700">
                    Location
                </label>

                <input
                    type="text"
                    name="location"
                    id="location"
                    value="{{ old('location', $profile?->location) }}"
                    placeholder="Indonesia"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"
                >
            </div>

        </div>
    </div>

    {{-- Profile Description --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <div class="mb-6">
            <h4 class="font-heading text-lg font-bold text-slate-900">
                Profile Description
            </h4>
            <p class="mt-1 text-sm text-slate-500">
                Perkenalkan diri Anda kepada calon klien.
            </p>
        </div>

        <div class="mb-5">
            <label for="short_bio" class="mb-2 block text-sm font-semibold text-slate-700">
                Short Bio
            </label>

            <textarea
                name="short_bio"
                id="short_bio"
                rows="3"
                placeholder="Deskripsi singkat yang akan ditampilkan pada Hero Section..."
                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"
            >{{ old('short_bio', $profile?->short_bio) }}</textarea>
        </div>

        <div>
            <label for="about" class="mb-2 block text-sm font-semibold text-slate-700">
                About Me
            </label>

            <textarea
                name="about"
                id="about"
                rows="8"
                placeholder="Ceritakan pengalaman, pendekatan kerja, dan keahlian Anda..."
                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"
            >{{ old('about', $profile?->about) }}</textarea>
        </div>

    </div>

    {{-- Contact Information --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <div class="mb-6">
            <h4 class="font-heading text-lg font-bold text-slate-900">
                Contact Information
            </h4>
            <p class="mt-1 text-sm text-slate-500">
                Informasi yang dapat digunakan calon klien untuk menghubungi Anda.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">

            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
                    Professional Email
                </label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email', $profile?->email) }}"
                    placeholder="hello@example.com"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"
                >
            </div>

            <div>
                <label for="whatsapp" class="mb-2 block text-sm font-semibold text-slate-700">
                    WhatsApp Number
                </label>

                <input
                    type="text"
                    name="whatsapp"
                    id="whatsapp"
                    value="{{ old('whatsapp', $profile?->whatsapp) }}"
                    placeholder="6281234567890"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"
                >

                <p class="mt-2 text-xs text-slate-400">
                    Gunakan format internasional, contoh: 6281234567890.
                </p>
            </div>

        </div>
    </div>

    {{-- Social Media --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <div class="mb-6">
            <h4 class="font-heading text-lg font-bold text-slate-900">
                Social Media
            </h4>
            <p class="mt-1 text-sm text-slate-500">
                Tambahkan tautan media sosial profesional Anda. Semua field bersifat opsional.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">

            <div>
                <label for="linkedin" class="mb-2 block text-sm font-semibold text-slate-700">
                    LinkedIn URL
                </label>

                <input
                    type="url"
                    name="linkedin"
                    id="linkedin"
                    value="{{ old('linkedin', $profile?->linkedin) }}"
                    placeholder="https://linkedin.com/in/username"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"
                >
            </div>

            <div>
                <label for="github" class="mb-2 block text-sm font-semibold text-slate-700">
                    GitHub URL
                </label>

                <input
                    type="url"
                    name="github"
                    id="github"
                    value="{{ old('github', $profile?->github) }}"
                    placeholder="https://github.com/username"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"
                >
            </div>

            <div>
                <label for="instagram" class="mb-2 block text-sm font-semibold text-slate-700">
                    Instagram URL
                </label>

                <input
                    type="url"
                    name="instagram"
                    id="instagram"
                    value="{{ old('instagram', $profile?->instagram) }}"
                    placeholder="https://www.instagram.com/username/"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"
                >
            </div>

            <div>
                <label for="tiktok" class="mb-2 block text-sm font-semibold text-slate-700">
                    TikTok URL
                </label>

                <input
                    type="url"
                    name="tiktok"
                    id="tiktok"
                    value="{{ old('tiktok', $profile?->tiktok) }}"
                    placeholder="https://www.tiktok.com/@username"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"
                >
            </div>

        </div>
    </div>
    {{-- Availability --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <h4 class="font-heading text-lg font-bold text-slate-900">
            Availability Status
        </h4>

        <label class="mt-5 flex cursor-pointer items-center gap-3">

            <input
                type="checkbox"
                name="availability_status"
                value="1"
                @checked(old('availability_status', $profile?->availability_status ?? true))
                class="h-5 w-5 rounded accent-amber-400"
            >

            <span class="text-sm font-medium text-slate-700">
                Available for freelance opportunities
            </span>

        </label>
    </div>

    {{-- Bottom Save Button --}}
    <div class="flex justify-end">
        <button
            type="submit"
            class="rounded-xl bg-amber-400 px-6 py-3 text-sm font-bold text-slate-900 transition hover:bg-amber-300"
        >
            Save Changes
        </button>
    </div>

</form>

@endsection

