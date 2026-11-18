@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Overview of your portfolio and website content.')

@section('content')

    {{-- Welcome Header --}}
    <div class="mb-8">
        <h3 class="font-heading text-2xl font-bold text-slate-900">
            Welcome Back, {{ auth()->user()->name }}!
        </h3>
        <p class="mt-2 text-sm text-slate-500">
            Here is an overview of your portfolio content.
        </p>
    </div>

    {{-- Statistics --}}
    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">

        @foreach ($statistics as $stat)
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">
                    {{ $stat['label'] }}
                </p>

                <h4 class="mt-3 font-heading text-3xl font-bold text-slate-900">
                    {{ number_format($stat['value']) }}
                </h4>

                <p class="mt-2 text-xs text-slate-400">
                    {{ $stat['description'] }}
                </p>
            </div>
        @endforeach

    </div>

    {{-- Project Overview --}}
    <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <div class="mb-6">
            <h3 class="font-heading text-lg font-bold text-slate-900">
                Project Overview
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Breakdown of projects by current status.
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

            @foreach ([
                'in_progress' => ['label' => 'In Progress', 'color' => 'bg-blue-500'],
                'completed' => ['label' => 'Completed', 'color' => 'bg-emerald-500'],
                'on_hold' => ['label' => 'On Hold', 'color' => 'bg-amber-500'],
                'cancelled' => ['label' => 'Cancelled', 'color' => 'bg-red-500'],
            ] as $status => $item)

                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                    <div class="flex items-center gap-2">
                        <span class="h-2.5 w-2.5 rounded-full {{ $item['color'] }}"></span>

                        <span class="text-sm font-medium text-slate-600">
                            {{ $item['label'] }}
                        </span>
                    </div>

                    <p class="mt-3 font-heading text-2xl font-bold text-slate-900">
                        {{ number_format($projectStatus[$status]) }}
                    </p>
                </div>

            @endforeach

        </div>
    </div>

    {{-- Recent Projects --}}
    <div class="mt-8 rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="flex items-center justify-between border-b border-slate-100 p-6">
            <div>
                <h3 class="font-heading text-lg font-bold text-slate-900">
                    Recent Projects
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Latest projects registered in your portfolio.
                </p>
            </div>

            <a href="{{ route('admin.projects.index') }}"
               class="text-sm font-semibold text-amber-600 transition hover:text-amber-700">
                View All →
            </a>
        </div>

        @forelse ($recentProjects as $project)

            <div class="flex flex-col gap-3 border-b border-slate-100 p-5 last:border-0 sm:flex-row sm:items-center sm:justify-between">

                <div class="min-w-0">
                    <h4 class="truncate text-sm font-semibold text-slate-800">
                        {{ $project->title }}
                    </h4>

                    <p class="mt-1 text-xs text-slate-500">
                        {{ $project->category?->name ?? 'Uncategorized' }}
                    </p>
                </div>

                @php
                    $statusStyles = [
                        'in_progress' => 'bg-blue-50 text-blue-700',
                        'completed' => 'bg-emerald-50 text-emerald-700',
                        'on_hold' => 'bg-amber-50 text-amber-700',
                        'cancelled' => 'bg-red-50 text-red-700',
                    ];

                    $statusLabels = [
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'on_hold' => 'On Hold',
                        'cancelled' => 'Cancelled',
                    ];
                @endphp

                <span class="w-fit rounded-full px-3 py-1 text-xs font-semibold {{ $statusStyles[$project->status] ?? 'bg-slate-100 text-slate-600' }}">
                    {{ $statusLabels[$project->status] ?? ucfirst($project->status) }}
                </span>

            </div>

        @empty

            <div class="p-8 text-center">
                <p class="text-sm text-slate-500">
                    No projects available yet.
                </p>
            </div>

        @endforelse

    </div>

    {{-- Recent Experience --}}
    <div class="mt-8 rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-100 p-6">
            <h3 class="font-heading text-lg font-bold text-slate-900">
                Professional Experience
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Your latest professional experience records.
            </p>
        </div>

        @forelse ($recentExperiences as $experience)

            <div class="border-b border-slate-100 p-5 last:border-0">

                <h4 class="text-sm font-semibold text-slate-800">
                    {{ $experience->job_title }}
                </h4>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $experience->company }}
                    @if($experience->location)
                        · {{ $experience->location }}
                    @endif
                </p>

                <p class="mt-2 text-xs text-slate-400">
                    {{ $experience->start_date?->format('M Y') ?? 'N/A' }}
                    —
                    @if($experience->is_current)
                        Present
                    @else
                        {{ $experience->end_date?->format('M Y') ?? 'N/A' }}
                    @endif
                </p>

            </div>

        @empty

            <div class="p-8 text-center">
                <p class="text-sm text-slate-500">
                    No professional experience available yet.
                </p>
            </div>

        @endforelse

    </div>

@endsection
