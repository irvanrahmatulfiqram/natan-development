
@extends('layouts.admin')

@section('title', 'Education')
@section('page-title', 'Education')
@section('page-description', 'Kelola riwayat pendidikan dan latar belakang akademik.')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h3 class="font-heading text-xl font-bold text-slate-900">
                Education Management
            </h3>
            <p class="mt-1 text-sm text-slate-500">
                Kelola jenjang pendidikan, institusi, dan riwayat akademik.
            </p>
        </div>

        <button
            type="button"
            data-education-open="create"
            class="rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-slate-900 transition hover:bg-amber-300">
            + Add Education
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

    {{-- Education Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">

                <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Degree</th>
                        <th class="px-6 py-4">Field of Study</th>
                        <th class="px-6 py-4">Period</th>
                        <th class="px-6 py-4">Location</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($educations as $education)
                        <tr class="transition hover:bg-slate-50">

                            {{-- Degree and Institution --}}
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-slate-800">
                                        {{ $education->degree }}
                                    </p>
                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $education->institution }}
                                    </p>
                                </div>
                            </td>

                            {{-- Field of Study --}}
                            <td class="px-6 py-4 text-slate-600">
                                {{ $education->field_of_study ?: '-' }}
                            </td>

                            {{-- Period --}}
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-slate-700">
                                    {{ $education->start_date->format('M Y') }}
                                    -
                                    {{ $education->is_current ? 'Present' : ($education->end_date?->format('M Y') ?? '-') }}
                                </p>

                                @if($education->is_current)
                                    <p class="mt-1 text-xs font-medium text-green-600">
                                        Currently Studying
                                    </p>
                                @endif
                            </td>

                            {{-- Location --}}
                            <td class="px-6 py-4 text-slate-600">
                                {{ $education->location ?: '-' }}
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center gap-1.5">

                                    @if($education->is_current)
                                        <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                            Current
                                        </span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                            Completed
                                        </span>
                                    @endif

                                    @if($education->is_active)
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
                                        data-education-open="edit"
                                        data-education-degree="{{ $education->degree }}"
                                        data-education-institution="{{ $education->institution }}"
                                        data-education-field="{{ $education->field_of_study }}"
                                        data-education-location="{{ $education->location }}"
                                        data-education-start-date="{{ $education->start_date->format('Y-m-d') }}"
                                        data-education-end-date="{{ $education->end_date?->format('Y-m-d') }}"
                                        data-education-current="{{ $education->is_current ? '1' : '0' }}"
                                        data-education-description="{{ $education->description }}"
                                        data-education-active="{{ $education->is_active ? '1' : '0' }}"
                                        data-education-update-url="{{ route('admin.educations.update', $education) }}"
                                        class="cursor-pointer font-semibold text-amber-600 transition hover:text-amber-700">
                                        Edit
                                    </button>

                                    {{-- Delete --}}
                                    <button
                                        type="button"
                                        data-education-delete-open
                                        data-education-delete-url="{{ route('admin.educations.destroy', $education) }}"
                                        data-education-delete-name="{{ $education->degree }} - {{ $education->institution }}"
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
                                    Belum ada riwayat pendidikan.
                                </p>
                                <p class="mt-2 text-sm text-slate-400">
                                    Tambahkan riwayat pendidikan pertama Anda.
                                </p>
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

        <div class="border-t border-slate-100 px-6 py-4 text-sm text-slate-500">
            Total {{ $educations->count() }} Education Records
        </div>
    </div>

</div>


{{-- Education Modal --}}
<div
    id="education-modal"
    data-modal
    class="fixed inset-0 z-[100] hidden items-center justify-center overflow-y-auto bg-slate-900/50 px-4 py-6 backdrop-blur-sm">

    <div class="my-auto w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
            <div>
                <h3 id="education-modal-title" class="font-heading text-xl font-bold text-slate-900">
                    New Education
                </h3>
                <p id="education-modal-description" class="mt-1 text-sm text-slate-500">
                    Lengkapi informasi riwayat pendidikan.
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
            id="education-form"
            action="{{ route('admin.educations.store') }}"
            data-store-url="{{ route('admin.educations.store') }}"
            method="POST">

            @csrf

            <input type="hidden" name="_method" id="education-method" value="POST">

            <div class="max-h-[65vh] space-y-5 overflow-y-auto px-6 py-6">

                {{-- Degree and Institution --}}
                <div class="grid gap-5 md:grid-cols-2">

                    <div>
                        <label for="education-degree" class="mb-2 block text-sm font-semibold text-slate-700">
                            Degree *
                        </label>
                        <input
                            type="text"
                            name="degree"
                            id="education-degree"
                            required
                            maxlength="100"
                            placeholder="Contoh: S1, D3, SMA/SMK"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">
                    </div>

                    <div>
                        <label for="education-institution" class="mb-2 block text-sm font-semibold text-slate-700">
                            Institution *
                        </label>
                        <input
                            type="text"
                            name="institution"
                            id="education-institution"
                            required
                            maxlength="255"
                            placeholder="Contoh: Universitas Putra Indonesia YPTK Padang"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">
                    </div>

                </div>

                {{-- Field of Study --}}
                <div>
                    <label for="education-field" class="mb-2 block text-sm font-semibold text-slate-700">
                        Field of Study
                    </label>
                    <input
                        type="text"
                        name="field_of_study"
                        id="education-field"
                        maxlength="255"
                        placeholder="Contoh: Teknik Informatika"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">
                </div>

                {{-- Location --}}
                <div>
                    <label for="education-location" class="mb-2 block text-sm font-semibold text-slate-700">
                        Location
                    </label>
                    <input
                        type="text"
                        name="location"
                        id="education-location"
                        maxlength="255"
                        placeholder="Contoh: Padang, Indonesia"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">
                </div>

                {{-- Dates --}}
                <div class="grid gap-5 md:grid-cols-2">

                    <div>
                        <label for="education-start-date" class="mb-2 block text-sm font-semibold text-slate-700">
                            Start Date *
                        </label>
                        <input
                            type="date"
                            name="start_date"
                            id="education-start-date"
                            required
                            max="{{ now()->toDateString() }}"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">
                    </div>

                    <div id="education-end-date-container">
                        <label for="education-end-date" class="mb-2 block text-sm font-semibold text-slate-700">
                            End Date
                        </label>
                        <input
                            type="date"
                            name="end_date"
                            id="education-end-date"
                            max="{{ now()->toDateString() }}"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">
                    </div>

                </div>

                {{-- Current Education --}}
                <label class="flex cursor-pointer items-center gap-3">
                    <input type="hidden" name="is_current" value="0">

                    <input
                        type="checkbox"
                        name="is_current"
                        id="education-current"
                        value="1"
                        class="h-5 w-5 rounded accent-amber-400">

                    <span class="text-sm font-medium text-slate-700">
                        I am currently studying here
                    </span>
                </label>

                {{-- Description --}}
                <div>
                    <label for="education-description" class="mb-2 block text-sm font-semibold text-slate-700">
                        Description
                    </label>

                    <textarea
                        name="description"
                        id="education-description"
                        rows="7"
                        placeholder="Tuliskan informasi tambahan mengenai pendidikan, prestasi, atau kegiatan akademik."
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"></textarea>

                    <p class="mt-2 text-xs text-slate-400">
                        Informasi ini dapat digunakan untuk menjelaskan pencapaian atau aktivitas akademik.
                    </p>
                </div>

                {{-- Publication Status --}}
                <label class="flex cursor-pointer items-center gap-3">
                    <input type="hidden" name="is_active" value="0">

                    <input
                        type="checkbox"
                        name="is_active"
                        id="education-active"
                        value="1"
                        checked
                        class="h-5 w-5 rounded accent-amber-400">

                    <span class="text-sm font-medium text-slate-700">
                        Active
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
                    id="education-submit-button"
                    class="rounded-xl bg-amber-400 px-6 py-3 text-sm font-bold text-slate-900 transition hover:bg-amber-300">
                    Save Education
                </button>

            </div>

        </form>

    </div>
</div>


{{-- Delete Modal --}}
<div
    id="education-delete-modal"
    data-modal
    class="fixed inset-0 z-[110] hidden items-center justify-center bg-slate-900/50 px-4 backdrop-blur-sm">

    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">

        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-red-100 text-xl text-red-600">
            !
        </div>

        <h3 class="font-heading text-lg font-bold text-slate-900">
            Delete Education?
        </h3>

        <p class="mt-2 text-sm leading-6 text-slate-500">
            Apakah Anda yakin ingin menghapus riwayat pendidikan
            <strong id="education-delete-name" class="text-slate-800"></strong>?
            Data yang dihapus tidak dapat dikembalikan.
        </p>

        <form
            id="education-delete-form"
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
                Delete Education
            </button>

        </form>

    </div>
</div>

@endsection
