
@extends('layouts.admin')

@section('title', 'Experiences')
@section('page-title', 'Experiences')
@section('page-description', 'Kelola pengalaman profesional dan riwayat pekerjaan.')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h3 class="font-heading text-xl font-bold text-slate-900">
                Experience Management
            </h3>
            <p class="mt-1 text-sm text-slate-500">
                Kelola pengalaman kerja, tanggung jawab, dan pencapaian profesional.
            </p>
        </div>

        <button
            type="button"
            data-experience-open="create"
            class="rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-slate-900 transition hover:bg-amber-300">
            + Add Experience
        </button>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="mb-2 font-semibold">Terdapat kesalahan:</p>
            <ul class="list-inside list-disc space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Experiences Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">

                <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Position</th>
                        <th class="px-6 py-4">Employment Type</th>
                        <th class="px-6 py-4">Period</th>
                        <th class="px-6 py-4">Location</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($experiences as $experience)
                        <tr class="transition hover:bg-slate-50">

                            {{-- Position --}}
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-slate-800">
                                        {{ $experience->job_title }}
                                    </p>
                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $experience->company }}
                                    </p>
                                </div>
                            </td>

                            {{-- Employment Type --}}
                            <td class="px-6 py-4">
                                @php
                                    $employmentTypes = [
                                        'full_time' => 'Full-time',
                                        'part_time' => 'Part-time',
                                        'freelance' => 'Freelance',
                                        'internship' => 'Internship',
                                        'contract' => 'Contract',
                                        'self_employed' => 'Self-employed',
                                    ];
                                @endphp

                                <span class="inline-flex rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                    {{ $employmentTypes[$experience->employment_type] ?? 'Other' }}
                                </span>
                            </td>

                            {{-- Period --}}
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-slate-700">
                                    {{ $experience->start_date->format('M Y') }}
                                    -
                                    {{ $experience->is_current ? 'Present' : ($experience->end_date?->format('M Y') ?? '-') }}
                                </p>
                                @if($experience->is_current)
                                    <p class="mt-1 text-xs font-medium text-green-600">
                                        Currently Working
                                    </p>
                                @endif
                            </td>

                            {{-- Location --}}
                            <td class="px-6 py-4 text-slate-600">
                                {{ $experience->location ?: '-' }}
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center gap-1.5">

                                    @if($experience->is_current)
                                        <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                            Current
                                        </span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                            Completed
                                        </span>
                                    @endif

                                    @if($experience->is_active)
                                        <span class="text-xs font-medium text-green-600">
                                            Active
                                        </span>
                                    @else
                                        <span class="text-xs font-medium text-slate-400">
                                            Inactive
                                        </span>
                                    @endif

                                </div>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-3">

                                    {{-- Edit --}}
                                    <button
                                        type="button"
                                        data-experience-open="edit"
                                        data-experience-job-title="{{ $experience->job_title }}"
                                        data-experience-company="{{ $experience->company }}"
                                        data-experience-employment-type="{{ $experience->employment_type }}"
                                        data-experience-location="{{ $experience->location }}"
                                        data-experience-start-date="{{ $experience->start_date->format('Y-m-d') }}"
                                        data-experience-end-date="{{ $experience->end_date?->format('Y-m-d') }}"
                                        data-experience-current="{{ $experience->is_current ? '1' : '0' }}"
                                        data-experience-description="{{ $experience->description }}"
                                        data-experience-active="{{ $experience->is_active ? '1' : '0' }}"
                                        data-experience-update-url="{{ route('admin.experiences.update', $experience) }}"
                                        class="cursor-pointer font-semibold text-amber-600 transition hover:text-amber-700">
                                        Edit
                                    </button>

                                    {{-- Delete --}}
                                    <button
                                        type="button"
                                        data-experience-delete-open
                                        data-experience-delete-url="{{ route('admin.experiences.destroy', $experience) }}"
                                        data-experience-delete-name="{{ $experience->job_title }} - {{ $experience->company }}"
                                        class="cursor-pointer font-semibold text-red-500 transition hover:text-red-700">
                                        Delete
                                    </button>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <p class="font-semibold text-slate-600">
                                    Belum ada pengalaman kerja.
                                </p>
                                <p class="mt-2 text-sm text-slate-400">
                                    Tambahkan pengalaman profesional pertama Anda.
                                </p>
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

        <div class="border-t border-slate-100 px-6 py-4 text-sm text-slate-500">
            Total {{ $experiences->count() }} Experiences
        </div>
    </div>

</div>


{{-- EXPERIENCE MODAL --}}
<div
    id="experience-modal"
    data-modal
    class="fixed inset-0 z-[100] hidden items-center justify-center overflow-y-auto bg-slate-900/50 px-4 py-6 backdrop-blur-sm">

    <div class="my-auto w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
            <div>
                <h3 id="experience-modal-title" class="font-heading text-xl font-bold text-slate-900">
                    New Experience
                </h3>
                <p id="experience-modal-description" class="mt-1 text-sm text-slate-500">
                    Lengkapi informasi pengalaman profesional.
                </p>
            </div>

            <button
                type="button"
                data-modal-close
                aria-label="Close modal"
                class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                &times;
            </button>
        </div>

        {{-- Form --}}
        <form
            id="experience-form"
            action="{{ route('admin.experiences.store') }}"
            data-store-url="{{ route('admin.experiences.store') }}"
            method="POST">

            @csrf

            <input type="hidden" name="_method" id="experience-method" value="POST">

            <div class="max-h-[65vh] space-y-5 overflow-y-auto px-6 py-6">

                {{-- Position and Company --}}
                <div class="grid gap-5 md:grid-cols-2">

                    <div>
                        <label for="experience-job-title" class="mb-2 block text-sm font-semibold text-slate-700">
                            Job Title *
                        </label>
                        <input
                            type="text"
                            name="job_title"
                            id="experience-job-title"
                            required
                            maxlength="255"
                            placeholder="Contoh: Chief Operating Officer"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">
                    </div>

                    <div>
                        <label for="experience-company" class="mb-2 block text-sm font-semibold text-slate-700">
                            Company *
                        </label>
                        <input
                            type="text"
                            name="company"
                            id="experience-company"
                            required
                            maxlength="255"
                            placeholder="Contoh: Nona Jewelry"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">
                    </div>

                </div>

                {{-- Employment Type --}}
                <div>
                    <label for="experience-employment-type" class="mb-2 block text-sm font-semibold text-slate-700">
                        Employment Type *
                    </label>

                    <select
                        name="employment_type"
                        id="experience-employment-type"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">

                        <option value="">-- Select Employment Type --</option>
                        <option value="full_time">Full-time</option>
                        <option value="part_time">Part-time</option>
                        <option value="freelance">Freelance</option>
                        <option value="internship">Internship</option>
                        <option value="contract">Contract</option>
                        <option value="self_employed">Self-employed</option>

                    </select>
                </div>

                {{-- Location --}}
                <div>
                    <label for="experience-location" class="mb-2 block text-sm font-semibold text-slate-700">
                        Location
                    </label>
                    <input
                        type="text"
                        name="location"
                        id="experience-location"
                        maxlength="255"
                        placeholder="Contoh: Padang, Indonesia"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">
                </div>

                {{-- Dates --}}
                <div class="grid gap-5 md:grid-cols-2">

                    <div>
                        <label for="experience-start-date" class="mb-2 block text-sm font-semibold text-slate-700">
                            Start Date *
                        </label>
                        <input
                            type="date"
                            name="start_date"
                            id="experience-start-date"
                            required
                            max="{{ now()->toDateString() }}"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">
                    </div>

                    <div id="experience-end-date-container">
                        <label for="experience-end-date" class="mb-2 block text-sm font-semibold text-slate-700">
                            End Date
                        </label>
                        <input
                            type="date"
                            name="end_date"
                            id="experience-end-date"
                            max="{{ now()->toDateString() }}"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">
                    </div>

                </div>

                {{-- Current Employment --}}
                <label class="flex cursor-pointer items-center gap-3">
                    <input
                        type="checkbox"
                        name="is_current"
                        id="experience-current"
                        value="1"
                        class="h-5 w-5 rounded accent-amber-400">

                    <span class="text-sm font-medium text-slate-700">
                        I currently work here
                    </span>
                </label>

                {{-- Description --}}
                <div>
                    <label for="experience-description" class="mb-2 block text-sm font-semibold text-slate-700">
                        Responsibilities & Achievements
                    </label>

                    <textarea
                        name="description"
                        id="experience-description"
                        rows="7"
                        placeholder="Tuliskan tanggung jawab dan pencapaian. Gunakan satu poin untuk setiap baris.

Contoh:
Mengelola operasional seluruh outlet.
Mengembangkan Standard Operating Procedures (SOP).
Mengawasi performa penjualan dan inventory."
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"></textarea>

                    <p class="mt-2 text-xs text-slate-400">
                        Gunakan satu baris untuk setiap tanggung jawab atau pencapaian.
                    </p>
                </div>

                {{-- Publication Status --}}
                <label class="flex cursor-pointer items-center gap-3">
                    <input
                        type="checkbox"
                        name="is_active"
                        id="experience-active"
                        value="1"
                        checked
                        class="h-5 w-5 rounded accent-amber-400">

                    <span class="text-sm font-medium text-slate-700">
                        Active Experience
                    </span>
                </label>

            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-3 border-t border-slate-100 px-6 py-5">

                <button
                    type="button"
                    data-modal-close
                    class="rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Cancel
                </button>

                <button
                    type="submit"
                    id="experience-submit-button"
                    class="rounded-xl bg-amber-400 px-6 py-3 text-sm font-bold text-slate-900 transition hover:bg-amber-300">
                    Save Experience
                </button>

            </div>

        </form>

    </div>
</div>


{{-- DELETE MODAL --}}
<div
    id="experience-delete-modal"
    data-modal
    class="fixed inset-0 z-[110] hidden items-center justify-center bg-slate-900/50 px-4 backdrop-blur-sm">

    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">

        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-red-100 text-xl text-red-600">
            !
        </div>

        <h3 class="font-heading text-lg font-bold text-slate-900">
            Delete Experience?
        </h3>

        <p class="mt-2 text-sm leading-6 text-slate-500">
            Apakah Anda yakin ingin menghapus pengalaman
            <strong id="experience-delete-name" class="text-slate-800"></strong>?
            Data yang dihapus tidak dapat dikembalikan.
        </p>

        <form
            id="experience-delete-form"
            method="POST"
            class="mt-7 flex justify-end gap-3">

            @csrf
            @method('DELETE')

            <button
                type="button"
                data-modal-close
                class="rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                Cancel
            </button>

            <button
                type="submit"
                class="rounded-xl bg-red-500 px-5 py-3 text-sm font-bold text-white transition hover:bg-red-600">
                Delete Experience
            </button>

        </form>

    </div>
</div>

@endsection
