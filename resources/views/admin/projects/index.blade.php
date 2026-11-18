
@extends('layouts.admin')

@section('title', 'Projects')
@section('page-title', 'Projects')
@section('page-description', 'Kelola proyek yang ditampilkan pada portfolio.')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h3 class="font-heading text-xl font-bold text-slate-900">
                Projects Management
            </h3>
            <p class="mt-1 text-sm text-slate-500">
                Kelola portofolio proyek dan teknologi yang digunakan.
            </p>
        </div>

        <button
            type="button"
            data-project-open="create"
            class="rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-slate-900 transition hover:bg-amber-300">
            + Add Project
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

    {{-- Projects Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">

                <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Project</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Technologies</th>
                        <th class="px-6 py-4 text-center">Order</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($projects as $project)
                        <tr class="transition hover:bg-slate-50">

                            {{-- Project Information --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">

                                    @if($project->thumbnail)
                                        <img
                                            src="{{ Storage::disk('public')->url($project->thumbnail) }}"
                                            alt="{{ $project->title }}"
                                            class="h-14 w-20 rounded-lg border border-slate-200 object-cover">
                                    @else
                                        <div class="flex h-14 w-20 items-center justify-center rounded-lg bg-slate-100 text-xs text-slate-400">
                                            No Image
                                        </div>
                                    @endif

                                    <div class="min-w-0">
                                        <p class="font-semibold text-slate-800">
                                            {{ $project->title }}
                                        </p>
                                        <p class="mt-1 text-xs text-slate-400">
                                            {{ $project->slug }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            {{-- Project Category --}}
                            <td class="px-6 py-4">
                                @if($project->category)
                                    <span class="inline-flex rounded-lg bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700">
                                        {{ $project->category->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">
                                        Uncategorized
                                    </span>
                                @endif
                            </td>

                            {{-- Technologies --}}
                            <td class="px-6 py-4">
                                <div class="flex max-w-xs flex-wrap gap-1.5">
                                    @forelse($project->skills as $skill)
                                        <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600">
                                            {{ $skill->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400">
                                            No technologies
                                        </span>
                                    @endforelse
                                </div>
                            </td>

                            {{-- Display Order --}}
                            <td class="px-6 py-4 text-center text-slate-600">
                                {{ $project->sort_order }}
                            </td>

                            {{-- Project Status --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center gap-1.5">

                                    @switch($project->status)

                                        @case('in_progress')
                                            <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                                In Progress
                                            </span>
                                            @break

                                        @case('completed')
                                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                                Completed
                                            </span>
                                            @break

                                        @case('on_hold')
                                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                                On Hold
                                            </span>
                                            @break

                                        @case('cancelled')
                                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                                Cancelled
                                            </span>
                                            @break

                                        @default
                                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                                Unknown
                                            </span>

                                    @endswitch

                                    {{-- Publication Status --}}
                                    @if($project->is_active)
                                        <span class="text-xs font-medium text-green-600">
                                            Active
                                        </span>
                                    @else
                                        <span class="text-xs font-medium text-slate-400">
                                            Inactive
                                        </span>
                                    @endif

                                    {{-- Featured Status --}}
                                    @if($project->is_featured)
                                        <span class="text-xs font-semibold text-amber-600">
                                            Featured
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
                                        data-project-open="edit"
                                        data-project-id="{{ $project->id }}"
                                        data-project-title="{{ $project->title }}"
                                        data-project-category="{{ $project->category_id }}"
                                        data-project-summary="{{ $project->summary }}"
                                        data-project-description="{{ $project->description }}"
                                        data-project-live-url="{{ $project->live_url }}"
                                        data-project-repository-url="{{ $project->repository_url }}"
                                        data-project-order="{{ $project->sort_order }}"
                                        data-project-status="{{ $project->status }}"
                                        data-project-featured="{{ $project->is_featured ? '1' : '0' }}"
                                        data-project-active="{{ $project->is_active ? '1' : '0' }}"
                                        data-project-skills="{{ $project->skills->pluck('id')->implode(',') }}"
                                        data-project-thumbnail="{{ $project->thumbnail ? Storage::disk('public')->url($project->thumbnail) : '' }}"
                                        data-project-update-url="{{ route('admin.projects.update', $project) }}"
                                        class="cursor-pointer font-semibold text-amber-600 transition hover:text-amber-700">
                                        Edit
                                    </button>

                                    {{-- Delete --}}
                                    <button
                                        type="button"
                                        data-project-delete-open
                                        data-project-delete-url="{{ route('admin.projects.destroy', $project) }}"
                                        data-project-delete-name="{{ $project->title }}"
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
                                    Belum ada proyek.
                                </p>
                                <p class="mt-2 text-sm text-slate-400">
                                    Tambahkan proyek pertama Anda.
                                </p>
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

        <div class="border-t border-slate-100 px-6 py-4 text-sm text-slate-500">
            Total {{ $projects->count() }} Projects
        </div>

    </div>

</div>


{{-- PROJECT MODAL --}}
<div
    id="project-modal"
    data-modal
    class="fixed inset-0 z-[100] hidden items-center justify-center overflow-y-auto bg-slate-900/50 px-4 py-6 backdrop-blur-sm">

    <div class="my-auto w-full max-w-3xl overflow-hidden rounded-2xl bg-white shadow-2xl">

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
            <div>
                <h3 id="project-modal-title" class="font-heading text-xl font-bold text-slate-900">
                    New Project
                </h3>
                <p id="project-modal-description" class="mt-1 text-sm text-slate-500">
                    Lengkapi informasi proyek.
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
            id="project-form"
            action="{{ route('admin.projects.store') }}"
            data-store-url="{{ route('admin.projects.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <input type="hidden" name="_method" id="project-method" value="POST">

            <div class="max-h-[65vh] space-y-5 overflow-y-auto px-6 py-6">

                {{-- Title --}}
                <div>
                    <label for="project-title" class="mb-2 block text-sm font-semibold text-slate-700">
                        Project Name *
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="project-title"
                        required
                        maxlength="255"
                        placeholder="Contoh: Natan Development Portfolio"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">
                </div>

                {{-- Project Category --}}
                <div>
                    <label for="project-category" class="mb-2 block text-sm font-semibold text-slate-700">
                        Project Category
                    </label>

                    <select
                        name="category_id"
                        id="project-category"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">

                        <option value="">-- Select Category --</option>

                        @foreach($projectCategories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                                {{ !$category->is_active ? '(Inactive)' : '' }}
                            </option>
                        @endforeach

                    </select>

                    <p class="mt-2 text-xs text-slate-400">
                        Pilih kategori utama yang paling sesuai dengan proyek ini.
                    </p>
                </div>

                {{-- Summary --}}
                <div>
                    <label for="project-summary" class="mb-2 block text-sm font-semibold text-slate-700">
                        Short Summary
                    </label>
                    <textarea
                        name="summary"
                        id="project-summary"
                        rows="2"
                        maxlength="500"
                        placeholder="Ringkasan singkat proyek..."
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"></textarea>
                </div>

                {{-- Description --}}
                <div>
                    <label for="project-description" class="mb-2 block text-sm font-semibold text-slate-700">
                        Project Description
                    </label>
                    <textarea
                        name="description"
                        id="project-description"
                        rows="5"
                        placeholder="Jelaskan tujuan, fitur, dan proses pengembangan proyek..."
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10"></textarea>
                </div>

                {{-- Technologies / Skills --}}
                <div>
                    <div class="mb-3">
                        <label class="block text-sm font-semibold text-slate-700">
                            Technologies / Skills
                        </label>
                        <p class="mt-1 text-xs text-slate-400">
                            Pilih satu atau beberapa teknologi yang digunakan dalam proyek.
                        </p>
                    </div>

                    <div
                        id="project-skills"
                        class="max-h-72 space-y-5 overflow-y-auto rounded-xl border border-slate-200 bg-slate-50 p-4">

                        @forelse($skills->groupBy(fn ($skill) => $skill->category?->name ?? 'Uncategorized') as $categoryName => $categorySkills)

                            <div>
                                <h4 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-500">
                                    {{ $categoryName }}
                                </h4>

                                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                                    @foreach($categorySkills as $skill)
                                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-slate-200 bg-white px-3 py-2.5 transition hover:border-amber-400">

                                            <input
                                                type="checkbox"
                                                name="skills[]"
                                                value="{{ $skill->id }}"
                                                data-project-skill
                                                class="h-4 w-4 rounded border-slate-300 text-amber-500 focus:ring-amber-400">

                                            <span class="text-sm font-medium text-slate-700">
                                                {{ $skill->name }}

                                                @if(!$skill->is_active)
                                                    <span class="text-xs font-medium text-red-500">
                                                        (Inactive)
                                                    </span>
                                                @endif
                                            </span>

                                        </label>
                                    @endforeach

                                </div>
                            </div>

                        @empty
                            <p class="text-sm text-slate-400">
                                Belum ada Skills yang tersedia.
                            </p>
                        @endforelse

                    </div>
                </div>

                {{-- Thumbnail --}}
                <div>
                    <label for="project-thumbnail" class="mb-2 block text-sm font-semibold text-slate-700">
                        Project Thumbnail
                    </label>

                    <input
                        type="file"
                        name="thumbnail"
                        id="project-thumbnail"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-amber-100 file:px-4 file:py-2 file:text-xs file:font-bold file:text-amber-800">

                    <p class="mt-2 text-xs text-slate-400">
                        Format JPG, JPEG, PNG, atau WebP. Maksimal 2 MB.
                    </p>

                    <div id="project-thumbnail-preview-container" class="mt-4 hidden">
                        <img
                            id="project-thumbnail-preview"
                            src=""
                            alt="Project thumbnail preview"
                            class="max-h-48 rounded-xl border border-slate-200 object-cover">
                    </div>
                </div>

                {{-- URLs --}}
                <div class="grid gap-5 md:grid-cols-2">

                    <div>
                        <label for="project-live-url" class="mb-2 block text-sm font-semibold text-slate-700">
                            Live Project URL
                        </label>
                        <input
                            type="url"
                            name="live_url"
                            id="project-live-url"
                            maxlength="2048"
                            placeholder="https://example.com"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">
                    </div>

                    <div>
                        <label for="project-repository-url" class="mb-2 block text-sm font-semibold text-slate-700">
                            Repository URL
                        </label>
                        <input
                            type="url"
                            name="repository_url"
                            id="project-repository-url"
                            maxlength="2048"
                            placeholder="https://github.com/..."
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">
                    </div>

                </div>

                {{-- Display Order --}}
                <div>
                    <label for="project-order" class="mb-2 block text-sm font-semibold text-slate-700">
                        Display Order
                    </label>
                    <input
                        type="number"
                        name="sort_order"
                        id="project-order"
                        min="0"
                        value="0"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">

                    <p class="mt-2 text-xs text-slate-400">
                        Angka lebih kecil akan ditampilkan lebih dahulu.
                    </p>
                </div>

                {{-- Project Status --}}
                <div>
                    <label for="project-status" class="mb-2 block text-sm font-semibold text-slate-700">
                        Project Status *
                    </label>

                    <select
                        name="status"
                        id="project-status"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10">

                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="on_hold">On Hold</option>
                        <option value="cancelled">Cancelled</option>

                    </select>

                    <p class="mt-2 text-xs text-slate-400">
                        Pilih status perkembangan proyek saat ini.
                    </p>
                </div>

                {{-- Options --}}
                <div class="space-y-4">

                    <label class="flex cursor-pointer items-center gap-3">
                        <input
                            type="checkbox"
                            name="is_featured"
                            id="project-featured"
                            value="1"
                            class="h-5 w-5 rounded accent-amber-400">

                        <span class="text-sm font-medium text-slate-700">
                            Featured Project
                        </span>
                    </label>

                    <label class="flex cursor-pointer items-center gap-3">
                        <input
                            type="checkbox"
                            name="is_active"
                            id="project-active"
                            value="1"
                            checked
                            class="h-5 w-5 rounded accent-amber-400">

                        <span class="text-sm font-medium text-slate-700">
                            Active Project
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
                    id="project-submit-button"
                    class="rounded-xl bg-amber-400 px-6 py-3 text-sm font-bold text-slate-900 transition hover:bg-amber-300">
                    Save Project
                </button>

            </div>

        </form>

    </div>
</div>


{{-- DELETE MODAL --}}
<div
    id="project-delete-modal"
    data-modal
    class="fixed inset-0 z-[110] hidden items-center justify-center bg-slate-900/50 px-4 backdrop-blur-sm">

    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">

        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-red-100 text-xl text-red-600">
            !
        </div>

        <h3 class="font-heading text-lg font-bold text-slate-900">
            Delete Project?
        </h3>

        <p class="mt-2 text-sm leading-6 text-slate-500">
            Apakah Anda yakin ingin menghapus proyek
            <strong id="project-delete-name" class="text-slate-800"></strong>?
            Data yang dihapus tidak dapat dikembalikan.
        </p>

        <form
            id="project-delete-form"
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
                Delete Project
            </button>

        </form>

    </div>
</div>

@endsection
