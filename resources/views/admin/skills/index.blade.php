@extends('layouts.admin')

@section('title', 'Skills')
@section('page-title', 'Skills')
@section('page-description', 'Kelola teknologi dan keahlian yang ditampilkan pada portfolio.')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h3 class="font-heading text-xl font-bold text-slate-900">
                Skills Management
            </h3>
            <p class="mt-1 text-sm text-slate-500">
                Kelola daftar teknologi dan keahlian Anda.
            </p>
        </div>

        <button
            type="button"
            data-skill-open="create"
            @disabled($categories->isEmpty())
            class="rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-slate-900 transition hover:bg-amber-300 disabled:cursor-not-allowed disabled:opacity-50">
            + Add Skill
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

    {{-- Filter --}}
    <div class="flex flex-wrap items-center gap-3">
        <label for="skill-category-filter" class="text-sm font-semibold text-slate-600">
            Filter Category:
        </label>

        <select
            id="skill-category-filter"
            class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">

            <option value="all">All Categories</option>

            @foreach($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach

        </select>
    </div>

    {{-- Skills Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">

                <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Skill</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4 text-center">Level</th>
                        <th class="px-6 py-4 text-center">Order</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody id="skills-table-body" class="divide-y divide-slate-100">

                    @forelse($skills as $skill)
                        <tr
                            data-skill-row
                            data-category-id="{{ $skill->skill_category_id }}"
                            class="transition hover:bg-slate-50">

                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-800">
                                    {{ $skill->name }}
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    {{ $skill->icon ?: 'No icon identifier' }}
                                </p>
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $skill->category->name ?? 'Category unavailable' }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($skill->proficiency_level)
                                    <span class="rounded-lg bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                        {{ $skill->proficiency_level }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">—</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center text-slate-600">
                                {{ $skill->sort_order }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center gap-1">

                                    @if($skill->is_active)
                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            Active
                                        </span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">
                                            Inactive
                                        </span>
                                    @endif

                                    @if($skill->is_featured)
                                        <span class="text-xs font-semibold text-amber-600">
                                            Featured
                                        </span>
                                    @endif

                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-3">

                                    {{-- Edit --}}
                                    <button
                                        type="button"
                                        data-skill-open="edit"
                                        data-skill-id="{{ $skill->id }}"
                                        data-skill-category-id="{{ $skill->skill_category_id }}"
                                        data-skill-name="{{ $skill->name }}"
                                        data-skill-icon="{{ $skill->icon }}"
                                        data-skill-level="{{ $skill->proficiency_level }}"
                                        data-skill-order="{{ $skill->sort_order }}"
                                        data-skill-featured="{{ $skill->is_featured ? '1' : '0' }}"
                                        data-skill-active="{{ $skill->is_active ? '1' : '0' }}"
                                        data-skill-update-url="{{ route('admin.skills.update', $skill) }}"
                                        class="font-semibold text-amber-600 transition hover:text-amber-700">
                                        Edit
                                    </button>

                                    {{-- Delete --}}
                                    <button
                                        type="button"
                                        data-skill-delete-open
                                        data-skill-delete-url="{{ route('admin.skills.destroy', $skill) }}"
                                        data-skill-delete-name="{{ $skill->name }}"
                                        class="font-semibold text-red-500 transition hover:text-red-700">
                                        Delete
                                    </button>

                                </div>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <p class="font-semibold text-slate-600">
                                    Belum ada Skill.
                                </p>
                                <p class="mt-2 text-sm text-slate-400">
                                    Tambahkan teknologi atau keahlian pertama Anda.
                                </p>
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

        <div class="border-t border-slate-100 px-6 py-4 text-sm text-slate-500">
            Total {{ $skills->count() }} Skills
        </div>

    </div>

    @if($categories->isEmpty())
        <p class="text-sm text-amber-700">
            Belum ada kategori aktif. Aktifkan atau tambahkan kategori terlebih dahulu.
        </p>
    @endif

</div>


{{-- SKILL MODAL --}}
<div
    id="skill-modal"
    data-modal
    class="fixed inset-0 z-[100] hidden items-center justify-center overflow-y-auto bg-slate-900/50 px-4 py-6 backdrop-blur-sm">

    <div class="my-auto w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
            <div>
                <h3 id="skill-modal-title" class="font-heading text-xl font-bold text-slate-900">
                    New Skill
                </h3>

                <p id="skill-modal-description" class="mt-1 text-sm text-slate-500">
                    Lengkapi informasi Skill.
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
            id="skill-form"
            action="{{ route('admin.skills.store') }}"
            data-store-url="{{ route('admin.skills.store') }}"
            method="POST">

            @csrf

            <input type="hidden" name="_method" id="skill-method" value="POST">

            <div class="max-h-[65vh] space-y-5 overflow-y-auto px-6 py-6">

                {{-- Category --}}
                <div>
                    <label for="skill-category" class="mb-2 block text-sm font-semibold text-slate-700">
                        Category *
                    </label>

                    <select
                        name="skill_category_id"
                        id="skill-category"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">

                        <option value="">Select Category</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Skill Name --}}
                <div>
                    <label for="skill-name" class="mb-2 block text-sm font-semibold text-slate-700">
                        Skill Name *
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="skill-name"
                        required
                        maxlength="255"
                        placeholder="Contoh: Laravel"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">
                </div>

                {{-- Icon --}}
                <div>
                    <label for="skill-icon" class="mb-2 block text-sm font-semibold text-slate-700">
                        Icon Identifier
                    </label>

                    <input
                        type="text"
                        name="icon"
                        id="skill-icon"
                        maxlength="255"
                        placeholder="Contoh: laravel"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">

                    <p class="mt-2 text-xs text-slate-400">
                        Identifier ikon atau logo teknologi. Boleh dikosongkan.
                    </p>
                </div>

                {{-- Proficiency --}}
                <div>
                    <label for="skill-level" class="mb-2 block text-sm font-semibold text-slate-700">
                        Proficiency Level
                    </label>

                    <select
                        name="proficiency_level"
                        id="skill-level"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">

                        <option value="">Not specified</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                        <option value="Expert">Expert</option>

                    </select>
                </div>

                {{-- Display Order --}}
                <div>
                    <label for="skill-order" class="mb-2 block text-sm font-semibold text-slate-700">
                        Display Order
                    </label>

                    <input
                        type="number"
                        name="sort_order"
                        id="skill-order"
                        min="0"
                        value="0"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">

                    <p class="mt-2 text-xs text-slate-400">
                        Angka lebih kecil akan ditampilkan lebih dahulu.
                    </p>
                </div>

                {{-- Options --}}
                <div class="space-y-4">

                    <label class="flex cursor-pointer items-center gap-3">
                        <input
                            type="checkbox"
                            name="is_featured"
                            id="skill-featured"
                            value="1"
                            class="h-5 w-5 rounded accent-amber-400">

                        <span class="text-sm font-medium text-slate-700">
                            Featured Skill
                        </span>
                    </label>

                    <label class="flex cursor-pointer items-center gap-3">
                        <input
                            type="checkbox"
                            name="is_active"
                            id="skill-active"
                            value="1"
                            checked
                            class="h-5 w-5 rounded accent-amber-400">

                        <span class="text-sm font-medium text-slate-700">
                            Active Skill
                        </span>
                    </label>

                </div>

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
                    id="skill-submit-button"
                    class="rounded-xl bg-amber-400 px-6 py-3 text-sm font-bold text-slate-900 transition hover:bg-amber-300">
                    Save Skill
                </button>

            </div>

        </form>

    </div>
</div>


{{-- DELETE MODAL --}}
<div
    id="skill-delete-modal"
    data-modal
    class="fixed inset-0 z-[110] hidden items-center justify-center bg-slate-900/50 px-4 backdrop-blur-sm">

    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">

        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-red-100 text-xl text-red-600">
            !
        </div>

        <h3 class="font-heading text-lg font-bold text-slate-900">
            Delete Skill?
        </h3>

        <p class="mt-2 text-sm leading-6 text-slate-500">
            Apakah Anda yakin ingin menghapus Skill
            <strong id="skill-delete-name" class="text-slate-800"></strong>?
            Data yang dihapus tidak dapat dikembalikan.
        </p>

        <form
            id="skill-delete-form"
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
                Delete Skill
            </button>

        </form>

    </div>
</div>

@endsection
