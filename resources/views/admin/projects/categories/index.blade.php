@extends('layouts.admin')

@section('title', 'Project Categories')
@section('page-title', 'Project Categories')
@section('page-description', 'Kelola kategori proyek portfolio Anda.')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h3 class="font-heading text-xl font-bold text-slate-900">
                Category List
            </h3>
            <p class="mt-1 text-sm text-slate-500">
                Daftar kategori yang digunakan untuk mengelompokkan proyek.
            </p>
        </div>

        <button
            type="button"
            data-project-category-open="create"
            class="cursor-pointer rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-slate-900 transition hover:bg-amber-300">
            + Add Category
        </button>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation Errors --}}
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

    {{-- Categories Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4 text-center">Projects</th>
                        <th class="px-6 py-4 text-center">Order</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($categories as $category)
                        <tr class="transition hover:bg-slate-50">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-800">
                                    {{ $category->name }}
                                </p>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ $category->slug }}
                                </p>
                                @if($category->description)
                                    <p class="mt-1 max-w-md text-xs text-slate-500">
                                        {{ $category->description }}
                                    </p>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="rounded-lg bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                    {{ $category->projects_count }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center text-slate-600">
                                {{ $category->sort_order }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($category->is_active)
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    {{-- Edit --}}
                                    <button
                                        type="button"
                                        data-project-category-open="edit"
                                        data-project-category-name="{{ $category->name }}"
                                        data-project-category-description="{{ $category->description }}"
                                        data-project-category-order="{{ $category->sort_order }}"
                                        data-project-category-active="{{ $category->is_active ? '1' : '0' }}"
                                        data-project-category-update-url="{{ route('admin.project-categories.update', $category) }}"
                                        class="cursor-pointer font-semibold text-amber-600 transition hover:text-amber-700">
                                        Edit
                                    </button>

                                    {{-- Delete --}}
                                    <button
                                        type="button"
                                        data-project-category-delete-open
                                        data-project-category-delete-url="{{ route('admin.project-categories.destroy', $category) }}"
                                        data-project-category-delete-name="{{ $category->name }}"
                                        data-project-category-projects-count="{{ $category->projects_count }}"
                                        class="cursor-pointer font-semibold text-red-500 transition hover:text-red-700">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <p class="font-semibold text-slate-600">
                                    Belum ada kategori proyek.
                                </p>
                                <p class="mt-2 text-sm text-slate-400">
                                    Tambahkan kategori pertama Anda.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-100 px-6 py-4 text-sm text-slate-500">
            Total {{ $categories->count() }} kategori
        </div>
    </div>
</div>

{{-- PROJECT CATEGORY MODAL --}}
<div
    id="project-category-modal"
    data-modal
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/50 px-4 py-6 backdrop-blur-sm">

    <div class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">
        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
            <div>
                <h3
                    id="project-category-modal-title"
                    class="font-heading text-xl font-bold text-slate-900">
                    New Category
                </h3>

                <p
                    id="project-category-modal-description"
                    class="mt-1 text-sm text-slate-500">
                    Lengkapi informasi kategori proyek.
                </p>
            </div>

            <button
                type="button"
                data-modal-close
                class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                aria-label="Close modal">
                &times;
            </button>
        </div>

        {{-- Form --}}
        <form
            id="project-category-form"
            action="{{ route('admin.project-categories.store') }}"
            data-store-url="{{ route('admin.project-categories.store') }}"
            method="POST">

            @csrf

            <input
                type="hidden"
                name="_method"
                id="project-category-method"
                value="POST">

            <div class="space-y-5 px-6 py-6">
                <div>
                    <label
                        for="project-category-name"
                        class="mb-2 block text-sm font-semibold text-slate-700">
                        Category Name *
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="project-category-name"
                        required
                        maxlength="255"
                        placeholder="Contoh: Decision Support Systems"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">
                </div>

                <div>
                    <label
                        for="project-category-description"
                        class="mb-2 block text-sm font-semibold text-slate-700">
                        Description
                    </label>

                    <textarea
                        name="description"
                        id="project-category-description"
                        rows="4"
                        placeholder="Deskripsi singkat kategori proyek..."
                        class="w-full resize-y rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"></textarea>
                </div>

                <div>
                    <label
                        for="project-category-sort-order"
                        class="mb-2 block text-sm font-semibold text-slate-700">
                        Display Order
                    </label>

                    <input
                        type="number"
                        name="sort_order"
                        id="project-category-sort-order"
                        min="0"
                        value="0"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">

                    <p class="mt-2 text-xs text-slate-400">
                        Angka lebih kecil akan ditampilkan lebih dahulu.
                    </p>
                </div>

                <label class="flex cursor-pointer items-center gap-3">
                    <input
                        type="checkbox"
                        name="is_active"
                        id="project-category-is-active"
                        value="1"
                        checked
                        class="h-5 w-5 rounded accent-amber-400">

                    <span class="text-sm font-medium text-slate-700">
                        Active Category
                    </span>
                </label>
            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-3 border-t border-slate-100 px-6 py-5">
                <button
                    type="button"
                    data-modal-close
                    class="cursor-pointer rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Cancel
                </button>

                <button
                    type="submit"
                    id="project-category-submit-button"
                    class="cursor-pointer rounded-xl bg-amber-400 px-6 py-3 text-sm font-bold text-slate-900 transition hover:bg-amber-300">
                    Save Category
                </button>
            </div>
        </form>
    </div>
</div>

{{-- PROJECT CATEGORY DELETE MODAL --}}
<div
    id="project-category-delete-modal"
    data-modal
    class="fixed inset-0 z-[110] hidden items-center justify-center bg-slate-900/50 px-4 backdrop-blur-sm">

    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-red-100 text-xl text-red-600">
            !
        </div>

        <h3 class="font-heading text-lg font-bold text-slate-900">
            Delete Project Category?
        </h3>

        <p class="mt-2 text-sm leading-6 text-slate-500">
            Apakah Anda yakin ingin menghapus kategori
            <strong
                id="project-category-delete-name"
                class="text-slate-800"></strong>?
        </p>

        <p
            id="project-category-delete-info"
            class="mt-3 rounded-lg bg-amber-50 p-3 text-xs leading-5 text-amber-800">
            Proyek yang menggunakan kategori ini tidak akan dihapus.
            Kategorinya hanya akan dilepaskan dari proyek tersebut.
        </p>

        <form
            id="project-category-delete-form"
            method="POST"
            class="mt-7 flex justify-end gap-3">

            @csrf
            @method('DELETE')

            <button
                type="button"
                data-modal-close
                class="cursor-pointer rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                Cancel
            </button>

            <button
                type="submit"
                class="cursor-pointer rounded-xl bg-red-500 px-5 py-3 text-sm font-bold text-white transition hover:bg-red-600">
                Delete Category
            </button>
        </form>
    </div>
</div>
@endsection
