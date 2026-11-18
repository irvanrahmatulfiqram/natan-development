@extends('layouts.public')
@section('title', 'Home')
@section('content')
    @php
        $displayName = $profile?->name ?? 'Natan';
        $firstName = explode(' ', trim($displayName))[0];
        $rawWhatsappNumber = preg_replace('/\D+/', '', $profile?->whatsapp ?? '');

        if (str_starts_with($rawWhatsappNumber, '0062')) {
            $rawWhatsappNumber = substr($rawWhatsappNumber, 2);
        } elseif (str_starts_with($rawWhatsappNumber, '0')) {
            $rawWhatsappNumber = '62' . substr($rawWhatsappNumber, 1);
        } elseif (str_starts_with($rawWhatsappNumber, '8')) {
            $rawWhatsappNumber = '62' . $rawWhatsappNumber;
        }

        $whatsappNumber = $rawWhatsappNumber;
        $whatsappMessage = 'Halo, saya mengunjungi website Natan Development. Saya tertarik untuk berdiskusi mengenai layanan pengembangan website atau aplikasi. Boleh saya mendapatkan informasi lebih lanjut?';
    @endphp
    {{-- NAVBAR --}}
    <header class="fixed inset-x-0 top-0 z-50 border-b border-slate-200/70 bg-white/90 backdrop-blur-xl dark:border-slate-700/50 dark:bg-[#111827]/90">
        <nav class="container-main flex h-20 items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
            @if($siteSetting->site_logo)
                <img
                    src="{{ asset('storage/' . $siteSetting->site_logo) }}"
                    alt="{{ $siteSetting->site_name }}"
                    class="h-10 w-10 shrink-0 rounded-xl object-contain"
                >
            @else
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-900 font-heading text-xl font-bold text-white dark:bg-white dark:text-slate-900">
                    {{ strtoupper(substr($siteSetting->site_name, 0, 1)) }}
                </div>
            @endif
            <span class="font-heading text-lg font-bold tracking-tight">
                {{ $siteSetting->site_name }}
            </span>
        </a>
            {{-- DESKTOP NAVIGATION --}}
            <div class="hidden items-center gap-8 md:flex">
                <a href="#home" class="nav-link">Home</a>
                <a href="#about" class="nav-link">About</a>
                <a href="#experience" class="nav-link">Experience</a>
                <a href="#education" class="nav-link">Education</a>
                <a href="#projects" class="nav-link">Projects</a>
                <a href="#contact" class="nav-link">Contact Me</a>
            </div>
            {{-- ACTIONS --}}
            <div class="flex items-center gap-3">
                <button
                    type="button"
                    id="theme-toggle"
                    aria-label="Toggle color theme"
                    class="theme-button"
                >
                    <span id="theme-icon">☼</span>
                </button>
                <button
                    type="button"
                    id="mobile-menu-button"
                    aria-label="Open navigation menu"
                    aria-expanded="false"
                    class="theme-button md:hidden"
                >
                    <span id="menu-icon">☰</span>
                </button>
            </div>
        </nav>
        {{-- MOBILE NAVIGATION --}}
        <div id="mobile-menu" class="mobile-menu hidden border-t border-slate-200 bg-white px-6 py-5 dark:border-slate-700 dark:bg-[#111827] md:hidden">
            <div class="container-main flex flex-col gap-5">
                <a href="#home" class="nav-link">Home</a>
                <a href="#about" class="nav-link">About</a>
                <a href="#experience" class="nav-link">Experience</a>
                <a href="#education" class="nav-link">Education</a>
                <a href="#projects" class="nav-link">Projects</a>
                <a href="#contact" class="nav-link">Contact Me</a>
            </div>
        </div>
    </header>
    <main>
        {{-- HERO SECTION --}}
        <section id="home" class="hero-section">
            <div class="container-main">
                <div class="mx-auto max-w-4xl text-center">
                    {{-- AVAILABILITY --}}
                    @if($profile?->availability_status ?? true)
                        <div class="mb-8 inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 dark:border-slate-700 dark:bg-slate-800">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                            </span>
                            <span class="text-xs font-medium text-slate-600 dark:text-slate-300">
                                Available for Opportunities
                            </span>
                        </div>
                    @endif
                    {{-- PROFILE PHOTO --}}
                    @if($profile?->photo)
                        <div class="mb-6 flex justify-center">
                            <img
                                src="{{ asset('storage/' . $profile->photo) }}"
                                alt="{{ $profile->name }}"
                                class="h-40 w-40 rounded-full border-4 border-white object-cover shadow-xl ring-2 ring-amber-400 dark:border-slate-800"
                            >
                        </div>
                    @endif
                    {{-- INTRODUCTION --}}
                    <p class="mb-5 font-medium tracking-[0.2em] text-slate-500 dark:text-slate-400">
                        HELLO, I'M
                    </p>
                    <h1 class="font-heading text-4xl font-bold leading-tight tracking-tight sm:text-5xl md:text-6xl">
                      {{ $firstName }}<span class="text-amber-500">.</span>
                    </h1>
                    <h2 class="mt-6 font-heading text-2xl font-semibold sm:text-3xl md:text-4xl">
                        {{ $profile?->professional_title ?? 'Full Stack Web Developer' }}
                    </h2>
                    @if($profile?->tagline)
                        <p class="mt-4 font-heading text-lg font-medium text-amber-500 md:text-xl">
                            {{ $profile->tagline }}
                        </p>
                    @endif
                    {{-- DESCRIPTION --}}
                    @if($profile?->short_bio)
                        <p class="mx-auto mt-7 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-400 md:text-lg">
                            {{ $profile->short_bio }}
                        </p>
                    @endif
                    {{-- CTA BUTTONS --}}
                    <div class="mt-10 flex flex-col justify-center gap-4 sm:flex-row">
                        <a href="#projects" class="button-primary">
                            View Projects
                            <span aria-hidden="true">↗</span>
                        </a>
                        <a href="#contact" class="button-secondary">
                            Contact Me
                            <span aria-hidden="true">→</span>
                        </a>

</div>
                </div>
            </div>
        </section>
        {{-- ABOUT SECTION --}}
        <section id="about" class="section-container scroll-mt-20">
            <div class="container-main">
                <div class="mb-16 text-center">
                    <p class="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-amber-500">
                        Get To Know Me
                    </p>
                    <h2 class="section-heading">About Me</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-slate-500 dark:text-slate-400">
                        A little introduction about who I am and what I do.
                    </p>
                </div>
                <div class="grid items-start gap-12 lg:grid-cols-2">
                    {{-- INTRODUCTION --}}
                    <div>
                        <h3 class="mb-5 font-heading text-2xl font-bold">
                            Building Solutions Through Code
                        </h3>
                        @if($profile?->about)
                            <div class="space-y-5 leading-8 text-slate-600 dark:text-slate-400">
                                {!! nl2br(e($profile->about)) !!}
                            </div>
                        @else
                            <p class="leading-8 text-slate-600 dark:text-slate-400">
                                {{ $profile?->short_bio ?? 'Welcome to my portfolio.' }}
                            </p>
                        @endif
                    </div>
                    {{-- TECH STACK --}}
                    <div>
                        <h3 class="mb-6 font-heading text-2xl font-bold">
                            Tech Stack
                        </h3>
                        @forelse($skillCategories as $category)
                            <div class="mb-7 last:mb-0">
                                {{-- Category Name --}}
                                <h4 class="mb-3 text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    {{ $category->name }}
                                </h4>
                                {{-- Skills --}}
                                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                                    @foreach($category->skills as $skill)
                                        <div
                                            class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-4 text-center text-sm font-semibold text-slate-700 transition hover:-translate-y-1 hover:border-amber-400 dark:border-slate-700 dark:bg-slate-800/60 dark:text-slate-200">
                                            {{ $skill->name }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="rounded-xl border border-dashed border-slate-300 px-5 py-8 text-center dark:border-slate-700">
                                <p class="text-sm text-slate-500 dark:text-slate-400">
                                    Tech Stack information will be available soon.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
                {{-- SPECIALIZATION --}}
                <div class="mt-20">
                    <div class="mb-10 text-center">
                        <h3 class="font-heading text-2xl font-bold">
                            What I Do
                        </h3>
                        <p class="mt-3 text-slate-500 dark:text-slate-400">
                            Digital solutions I can help you build.
                        </p>
                    </div>
                    <div class="grid gap-6 md:grid-cols-3">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-7 dark:border-slate-700 dark:bg-slate-800/40">
                            <div class="mb-5 text-3xl text-amber-500">&lt;/&gt;</div>
                            <h4 class="mb-3 font-heading text-lg font-bold">
                                Web Development
                            </h4>
                            <p class="text-sm leading-7 text-slate-600 dark:text-slate-400">
                                Developing responsive, functional, and modern websites tailored to your needs.
                            </p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-7 dark:border-slate-700 dark:bg-slate-800/40">
                            <div class="mb-5 text-3xl text-amber-500">◈</div>
                            <h4 class="mb-3 font-heading text-lg font-bold">
                                Business Systems
                            </h4>
                            <p class="text-sm leading-7 text-slate-600 dark:text-slate-400">
                                Building information systems to simplify business operations and workflows.
                            </p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-7 dark:border-slate-700 dark:bg-slate-800/40">
                            <div class="mb-5 text-3xl text-amber-500">◉</div>
                            <h4 class="mb-3 font-heading text-lg font-bold">
                                Database Management
                            </h4>
                            <p class="text-sm leading-7 text-slate-600 dark:text-slate-400">
                                Designing structured databases and managing application data efficiently.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- EXPERIENCE SECTION --}}
        @if($experiences->isNotEmpty())
            <section id="experience" class="section-container scroll-mt-20">
                <div class="container-main">
                    <div class="mb-16 text-center">
                        <p class="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-amber-500">
                            My Professional Journey
                        </p>
                        <h2 class="section-heading">Experience</h2>
                        <p class="mx-auto mt-4 max-w-2xl text-slate-500 dark:text-slate-400">
                            My professional journey, responsibilities, and career development.
                        </p>
                    </div>
                    <div class="mx-auto max-w-3xl">
                        <div class="relative border-l-2 border-slate-200 pl-8 dark:border-slate-700">
                            @foreach($experiences as $experience)
                                @php
                                    $descriptionPoints = preg_split(
                                        '/\r\n|\r|\n/',
                                        $experience->description ?? ''
                                    );
                                    $descriptionPoints = array_filter(
                                        array_map('trim', $descriptionPoints)
                                    );
                                @endphp
                                <article class="relative pb-12 last:pb-0">
                                    {{-- TIMELINE DOT --}}
                                    <span class="absolute -left-[41px] top-1 h-5 w-5 rounded-full border-4 border-white bg-amber-500 dark:border-[#111827]"></span>
                                    {{-- PERIOD --}}
                                    <p class="mb-3 text-sm font-semibold text-amber-600 dark:text-amber-400">
                                        {{ $experience->start_date->format('M Y') }}
                                        —
                                        {{ $experience->is_current
                                            ? 'Present'
                                            : $experience->end_date?->format('M Y') }}
                                    </p>
                                    {{-- EXPERIENCE CARD --}}
                                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800/50">
                                        <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                            <div>
                                                <h3 class="font-heading text-xl font-bold">
                                                    {{ $experience->job_title }}
                                                </h3>
                                                <p class="mt-1 font-semibold text-slate-600 dark:text-slate-300">
                                                    {{ $experience->company }}
                                                </p>
                                            </div>
                                            @if($experience->is_current)
                                                <span class="w-fit rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                    Current
                                                </span>
                                            @endif
                                        </div>
                                        <div class="mt-3 flex flex-wrap gap-2 text-xs text-slate-500 dark:text-slate-400">
                                            <span class="rounded-lg bg-slate-100 px-3 py-1.5 dark:bg-slate-700">
                                                {{ ucwords(str_replace('_', ' ', $experience->employment_type)) }}
                                            </span>
                                            @if($experience->location)
                                                <span class="rounded-lg bg-slate-100 px-3 py-1.5 dark:bg-slate-700">
                                                    {{ $experience->location }}
                                                </span>
                                            @endif
                                        </div>
                                        @if(count($descriptionPoints))
                                            <ul class="mt-5 space-y-2 text-sm leading-7 text-slate-600 dark:text-slate-400">
                                                @foreach($descriptionPoints as $point)
                                                    <li class="flex gap-3">
                                                        <span class="mt-3 h-1.5 w-1.5 shrink-0 rounded-full bg-amber-500"></span>
                                                        <span>{{ $point }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
        {{-- EDUCATION SECTION --}}
        @if($educations->isNotEmpty())
            <section id="education" class="section-container scroll-mt-20">
                <div class="container-main">
                    {{-- SECTION HEADER --}}
                    <div class="mb-16 text-center">
                        <p class="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-amber-500">
                            My Academic Background
                        </p>
                        <h2 class="section-heading">
                            Education
                        </h2>
                        <p class="mx-auto mt-4 max-w-2xl text-slate-500 dark:text-slate-400">
                            My academic journey, educational background, and learning experience.
                        </p>
                    </div>
                    {{-- EDUCATION TIMELINE --}}
                    <div class="mx-auto max-w-3xl">
                        <div class="relative border-l-2 border-slate-200 pl-8 dark:border-slate-700">
                            @foreach($educations as $education)
                                @php
                                    $descriptionPoints = preg_split(
                                        '/\r\n|\r|\n/',
                                        $education->description ?? ''
                                    );
                                    $descriptionPoints = array_filter(
                                        array_map('trim', $descriptionPoints)
                                    );
                                @endphp
                                <article class="relative pb-12 last:pb-0">
                                    {{-- TIMELINE DOT --}}
                                    <span class="absolute -left-[41px] top-1 h-5 w-5 rounded-full border-4 border-white bg-amber-500 dark:border-[#111827]"></span>
                                    {{-- PERIOD --}}
                                    <p class="mb-3 text-sm font-semibold text-amber-600 dark:text-amber-400">
                                        {{ $education->start_date->format('M Y') }}
                                        —
                                        {{ $education->is_current
                                            ? 'Present'
                                            : $education->end_date?->format('M Y') }}
                                    </p>
                                    {{-- EDUCATION CARD --}}
                                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800/50">
                                        {{-- DEGREE AND INSTITUTION --}}
                                        <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                            <div>
                                                <h3 class="font-heading text-xl font-bold">
                                                    {{ $education->degree }}
                                                </h3>
                                                <p class="mt-1 font-semibold text-slate-600 dark:text-slate-300">
                                                    {{ $education->institution }}
                                                </p>
                                            </div>
                                            @if($education->is_current)
                                                <span class="w-fit rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                    Currently Studying
                                                </span>
                                            @endif
                                        </div>
                                        {{-- ADDITIONAL INFORMATION --}}
                                        <div class="mt-3 flex flex-wrap gap-2 text-xs text-slate-500 dark:text-slate-400">
                                            @if($education->field_of_study)
                                                <span class="rounded-lg bg-slate-100 px-3 py-1.5 dark:bg-slate-700">
                                                    {{ $education->field_of_study }}
                                                </span>
                                            @endif
                                            @if($education->location)
                                                <span class="rounded-lg bg-slate-100 px-3 py-1.5 dark:bg-slate-700">
                                                    {{ $education->location }}
                                                </span>
                                            @endif
                                        </div>
                                        {{-- DESCRIPTION --}}
                                        @if(count($descriptionPoints))
                                            <ul class="mt-5 space-y-2 text-sm leading-7 text-slate-600 dark:text-slate-400">
                                                @foreach($descriptionPoints as $point)
                                                    <li class="flex gap-3">
                                                        <span class="mt-3 h-1.5 w-1.5 shrink-0 rounded-full bg-amber-500"></span>
                                                        <span>{{ $point }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
        {{-- PROJECTS --}}
        <section id="projects" class="section-container scroll-mt-20">
            <div class="container-main">
                {{-- SECTION HEADER --}}
                <div class="mb-16 text-center">
                    <p class="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-amber-500">
                        My Recent Work
                    </p>
                    <h2 class="section-heading">Projects</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-slate-500 dark:text-slate-400">
                        Explore the projects I'm currently building and the solutions I've completed.
                    </p>
                </div>
                {{-- CURRENTLY WORKING ON --}}
                @if($currentlyWorkingProjects->isNotEmpty())
                    <div class="mb-20">
                        <div class="mb-10">
                            <h3 class="font-heading text-2xl font-bold">
                                Currently Working On
                            </h3>
                            <p class="mt-3 text-slate-500 dark:text-slate-400">
                                Projects that are currently under development.
                            </p>
                        </div>
                        <div class="grid gap-8 {{ $currentlyWorkingProjects->count() === 1
                            ? 'mx-auto max-w-2xl grid-cols-1'
                            : ($currentlyWorkingProjects->count() === 2
                                ? 'mx-auto max-w-5xl grid-cols-1 md:grid-cols-2'
                                : 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3') }}">
                            @foreach($currentlyWorkingProjects as $project)
                                <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white transition duration-300 hover:-translate-y-2 hover:border-amber-400 hover:shadow-xl dark:border-slate-700 dark:bg-slate-800/50">
                                    {{-- THUMBNAIL --}}
                                    <div class="aspect-video overflow-hidden bg-slate-100 dark:bg-slate-700">
                                        @if($project->thumbnail)
                                            <img
                                                src="{{ asset('storage/' . $project->thumbnail) }}"
                                                alt="{{ $project->title }}"
                                                loading="lazy"
                                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                            >
                                        @else
                                            <div class="flex h-full items-center justify-center">
                                                <span class="font-heading text-4xl font-bold text-slate-300 dark:text-slate-500">
                                                    N<span class="text-amber-500">.</span>
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    {{-- PROJECT INFORMATION --}}
                                    <div class="p-6">
                                        <div class="mb-3 flex flex-wrap items-center gap-2">
    <span class="inline-flex items-center gap-2 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
        <span class="h-2 w-2 rounded-full bg-blue-500"></span>
        In Progress
        </span>
        @if($project->category)
            <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                {{ $project->category->name }}
            </span>
        @endif
    </div>
                                        <h4 class="mb-3 font-heading text-xl font-bold">
                                            {{ $project->title }}
                                        </h4>
                                        @if($project->summary)
                                            <p class="mb-5 text-sm leading-7 text-slate-600 dark:text-slate-400">
                                                {{ $project->summary }}
                                            </p>
                                        @endif
                                        {{-- TECHNOLOGIES --}}
                                        @if($project->skills->isNotEmpty())
                                            <div class="mb-6 flex flex-wrap gap-2">
                                                @foreach($project->skills as $skill)
                                                    <span class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                                                        {{ $skill->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                        {{-- PROJECT LINKS --}}
                                        @if($project->live_url || $project->repository_url)
                                            <div class="flex flex-wrap gap-3 border-t border-slate-200 pt-5 dark:border-slate-700">
                                                @if($project->live_url)
                                                    <a
                                                        href="{{ $project->live_url }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="text-sm font-semibold text-amber-600 transition hover:text-amber-500 dark:text-amber-400"
                                                    >
                                                        Live Demo →
                                                    </a>
                                                @endif
                                                @if($project->repository_url)
                                                    <a
                                                        href="{{ $project->repository_url }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="text-sm font-semibold text-slate-600 transition hover:text-amber-500 dark:text-slate-300"
                                                    >
                                                        Source Code →
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
                {{-- FEATURED PROJECTS --}}
                @if($featuredProjects->isNotEmpty())
                    <div>
                        <div class="mb-10">
                            <h3 class="font-heading text-2xl font-bold">
                                Featured Projects
                            </h3>
                            <p class="mt-3 text-slate-500 dark:text-slate-400">
                                A selection of completed projects and solutions I've built.
                            </p>
                        </div>
                        <div class="grid gap-8 {{ $featuredProjects->count() === 1
                            ? 'mx-auto max-w-2xl grid-cols-1'
                            : ($featuredProjects->count() === 2
                                ? 'mx-auto max-w-5xl grid-cols-1 md:grid-cols-2'
                                : 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3') }}">
                            @foreach($featuredProjects as $project)
                                <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white transition duration-300 hover:-translate-y-2 hover:border-amber-400 hover:shadow-xl dark:border-slate-700 dark:bg-slate-800/50">
                                    {{-- THUMBNAIL --}}
                                    <div class="aspect-video overflow-hidden bg-slate-100 dark:bg-slate-700">
                                        @if($project->thumbnail)
                                            <img
                                                src="{{ asset('storage/' . $project->thumbnail) }}"
                                                alt="{{ $project->title }}"
                                                loading="lazy"
                                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                            >
                                        @else
                                            <div class="flex h-full items-center justify-center">
                                                <span class="font-heading text-4xl font-bold text-slate-300 dark:text-slate-500">
                                                    N<span class="text-amber-500">.</span>
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    {{-- PROJECT INFORMATION --}}
                                    <div class="p-6">
                                        @if($project->category)
                                        <div class="mb-3">
                                            <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                                {{ $project->category->name }}
                                            </span>
                                        </div>
                                    @endif
                                    <h4 class="mb-3 font-heading text-xl font-bold">
                                        {{ $project->title }}
                                    </h4>
                                        @if($project->summary)
                                            <p class="mb-5 text-sm leading-7 text-slate-600 dark:text-slate-400">
                                                {{ $project->summary }}
                                            </p>
                                        @endif
                                        {{-- TECHNOLOGIES --}}
                                        @if($project->skills->isNotEmpty())
                                            <div class="mb-6 flex flex-wrap gap-2">
                                                @foreach($project->skills as $skill)
                                                    <span class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                                                        {{ $skill->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                        {{-- PROJECT LINKS --}}
                                        @if($project->live_url || $project->repository_url)
                                            <div class="flex flex-wrap gap-3 border-t border-slate-200 pt-5 dark:border-slate-700">
                                                @if($project->live_url)
                                                    <a
                                                        href="{{ $project->live_url }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="text-sm font-semibold text-amber-600 transition hover:text-amber-500 dark:text-amber-400"
                                                    >
                                                        Live Demo →
                                                    </a>
                                                @endif
                                                @if($project->repository_url)
                                                    <a
                                                        href="{{ $project->repository_url }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="text-sm font-semibold text-slate-600 transition hover:text-amber-500 dark:text-slate-300"
                                                    >
                                                        Source Code →
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
                {{-- EMPTY STATE --}}
                @if($currentlyWorkingProjects->isEmpty() && $featuredProjects->isEmpty())
                    <div class="rounded-2xl border border-dashed border-slate-300 px-6 py-16 text-center dark:border-slate-700">
                        <h3 class="font-heading text-xl font-bold">
                            Projects Coming Soon
                        </h3>
                        <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">
                            I'm currently working on some exciting projects. Stay tuned!
                        </p>
                    </div>
                @endif
            </div>
        </section>

        {{-- CONTACT SECTION --}}

        <section id="contact" class="section-container scroll-mt-20">

            <div class="container-main">

                <div class="mx-auto mb-14 max-w-2xl text-center">

                    <p class="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-amber-500">

                        Get In Touch

                    </p>
                    <h2 class="section-heading">

                        Let's Connect

                    </h2>
                    <p class="mt-4 text-slate-500 dark:text-slate-400">

                        Have a project in mind, a question, or an opportunity to collaborate?

                        Feel free to reach out through any of the channels below.

                    </p>

                </div>
                <div class="mx-auto flex max-w-4xl flex-wrap items-start justify-center gap-x-8 gap-y-10 sm:gap-x-12">
                    @if($profile?->email)

                        <a href="mailto:{{ $profile->email }}" class="group flex w-20 flex-col items-center gap-3 text-center transition-transform duration-300 hover:-translate-y-2">

                            <svg viewBox="0 0 24 24" class="h-14 w-14 text-amber-500 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">

                                <rect x="3" y="5" width="18" height="14" rx="2"/>

                                <path d="m3 7 9 6 9-6"/>

                            </svg>

                            <span class="font-heading text-sm font-semibold text-slate-800 dark:text-slate-100">Email</span>

                        </a>

                    @endif
                    @if($profile?->linkedin)

                        <a href="{{ $profile->linkedin }}" target="_blank" rel="noopener noreferrer" class="group flex w-20 flex-col items-center gap-3 text-center transition-transform duration-300 hover:-translate-y-2">

                            <svg viewBox="0 0 24 24" class="h-14 w-14 text-[#0A66C2] transition-transform duration-300 group-hover:scale-110" fill="currentColor" aria-hidden="true">

                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.35V9h3.414v1.561h.049c.476-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286ZM5.337 7.433a2.062 2.062 0 1 1 0-4.124 2.062 2.062 0 0 1 0 4.124ZM7.119 20.452H3.555V9h3.564v11.452ZM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003Z"/>

                            </svg>

                            <span class="font-heading text-sm font-semibold text-slate-800 dark:text-slate-100">LinkedIn</span>

                        </a>

                    @endif
                    @if($profile?->github)

                        <a href="{{ $profile->github }}" target="_blank" rel="noopener noreferrer" class="group flex w-20 flex-col items-center gap-3 text-center transition-transform duration-300 hover:-translate-y-2">

                            <svg viewBox="0 0 24 24" class="h-14 w-14 text-slate-900 transition-transform duration-300 group-hover:scale-110 dark:text-white" fill="currentColor" aria-hidden="true">

                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 .75a11.25 11.25 0 0 0-3.56 21.92c.56.1.77-.24.77-.54v-2.1c-3.14.68-3.8-1.33-3.8-1.33-.51-1.3-1.25-1.65-1.25-1.65-1.02-.7.08-.69.08-.69 1.13.08 1.73 1.16 1.73 1.16 1 1.72 2.62 1.22 3.26.93.1-.73.39-1.22.71-1.5-2.5-.28-5.13-1.25-5.13-5.56 0-1.23.44-2.23 1.16-3.02-.12-.29-.5-1.43.11-2.98 0 0 .95-.3 3.1 1.15a10.8 10.8 0 0 1 5.64 0c2.15-1.45 3.1-1.15 3.1-1.15.62 1.55.23 2.69.12 2.98.72.79 1.15 1.79 1.15 3.02 0 4.32-2.63 5.27-5.14 5.55.4.35.76 1.03.76 2.08v3.1c0 .3.2.65.78.54A11.25 11.25 0 0 0 12 .75Z"/>

                            </svg>

                            <span class="font-heading text-sm font-semibold text-slate-800 dark:text-slate-100">GitHub</span>

                        </a>

                    @endif
                    @if($profile?->instagram)

                        <a href="{{ $profile->instagram }}" target="_blank" rel="noopener noreferrer" class="group flex w-20 flex-col items-center gap-3 text-center transition-transform duration-300 hover:-translate-y-2">

                            <svg viewBox="0 0 24 24" class="h-14 w-14 text-[#E4405F] transition-transform duration-300 group-hover:scale-110" fill="currentColor" aria-hidden="true">

                                <path d="M7.5 2h9A5.5 5.5 0 0 1 22 7.5v9a5.5 5.5 0 0 1-5.5 5.5h-9A5.5 5.5 0 0 1 2 16.5v-9A5.5 5.5 0 0 1 7.5 2Zm0 2A3.5 3.5 0 0 0 4 7.5v9A3.5 3.5 0 0 0 7.5 20h9a3.5 3.5 0 0 0 3.5-3.5v-9A3.5 3.5 0 0 0 16.5 4h-9ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm5.25-3.5a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5Z"/>

                            </svg>

                            <span class="font-heading text-sm font-semibold text-slate-800 dark:text-slate-100">Instagram</span>

                        </a>

                    @endif
                    @if($profile?->tiktok)

                        <a href="{{ $profile->tiktok }}" target="_blank" rel="noopener noreferrer" class="group flex w-20 flex-col items-center gap-3 text-center transition-transform duration-300 hover:-translate-y-2">

                            <svg viewBox="0 0 24 24" class="h-14 w-14 text-slate-900 transition-transform duration-300 group-hover:scale-110 dark:text-white" fill="currentColor" aria-hidden="true">

                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.42v13.67a2.9 2.9 0 0 1-2.9 2.9 2.9 2.9 0 1 1 2.9-2.9c0-.2-.02-.4-.06-.6V11.6a6.3 6.3 0 1 0 3.48 5.63V9.88a8.2 8.2 0 0 0 4.8 1.54V8a4.85 4.85 0 0 1-1.03-.11Z"/>

                            </svg>

                            <span class="font-heading text-sm font-semibold text-slate-800 dark:text-slate-100">TikTok</span>

                        </a>

                    @endif
                    @if($whatsappNumber)

                        <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode($whatsappMessage) }}" target="_blank" rel="noopener noreferrer" class="group flex w-20 flex-col items-center gap-3 text-center transition-transform duration-300 hover:-translate-y-2">

                            <svg viewBox="0 0 24 24" class="h-14 w-14 text-[#25D366] transition-transform duration-300 group-hover:scale-110" fill="currentColor" aria-hidden="true">

                                <path d="M20.52 3.48A11.85 11.85 0 0 0 12.08 0C5.5 0 .15 5.35.15 11.93c0 2.1.55 4.15 1.6 5.96L0 24l6.27-1.64a11.9 11.9 0 0 0 5.8 1.48h.01c6.58 0 11.93-5.35 11.93-11.93 0-3.19-1.24-6.19-3.49-8.43ZM12.08 21.8a9.9 9.9 0 0 1-5.04-1.38l-.36-.21-3.72.97.99-3.63-.24-.37a9.86 9.86 0 0 1-1.52-5.25c0-5.46 4.45-9.91 9.92-9.91 2.64 0 5.13 1.03 7 2.9a9.85 9.85 0 0 1 2.9 7c0 5.46-4.45 9.88-9.93 9.88Zm5.44-7.41c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.17.2-.35.22-.65.07-.3-.15-1.25-.46-2.38-1.46-.88-.78-1.47-1.75-1.64-2.05-.17-.3-.02-.46.13-.61.14-.13.3-.35.45-.52.15-.18.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.48-.5-.67-.51h-.57c-.2 0-.52.08-.8.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.87 1.22 3.07c.15.2 2.1 3.2 5.08 4.48.71.3 1.26.49 1.69.63.71.23 1.36.2 1.87.12.57-.08 1.76-.72 2.01-1.42.25-.7.25-1.29.17-1.42-.07-.13-.27-.2-.57-.35Z"/>

                            </svg>

                            <span class="font-heading text-sm font-semibold text-slate-800 dark:text-slate-100">WhatsApp</span>

                        </a>

                    @endif
                </div>

                @if(!$profile?->email && !$profile?->linkedin && !$profile?->github && !$profile?->instagram && !$profile?->tiktok && !$whatsappNumber)

                    <div class="mx-auto max-w-2xl rounded-2xl border border-dashed border-slate-300 px-6 py-10 text-center dark:border-slate-700">

                        <p class="text-sm text-slate-500 dark:text-slate-400">

                            Contact information will be available soon.

                        </p>

                    </div>

                @endif

            </div>

        </section>
    </main>
    {{-- FLOATING WHATSAPP BUTTON --}}
    @if($whatsappNumber)
        <a
            href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode($whatsappMessage) }}"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Open WhatsApp chat"
            class="fixed bottom-6 right-6 z-40 inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] p-3.5 text-white shadow-xl shadow-green-900/20 transition-all duration-300 hover:-translate-y-1 hover:bg-[#20BD5A] hover:shadow-2xl focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#25D366]"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="h-6 w-6 shrink-0"
                aria-hidden="true"
            >
                <path d="M20.52 3.48A11.85 11.85 0 0 0 12.08 0C5.5 0 .15 5.35.15 11.93c0 2.1.55 4.15 1.6 5.96L0 24l6.27-1.64a11.9 11.9 0 0 0 5.8 1.48h.01c6.58 0 11.93-5.35 11.93-11.93 0-3.19-1.24-6.19-3.49-8.43ZM12.08 21.8a9.9 9.9 0 0 1-5.04-1.38l-.36-.21-3.72.97.99-3.63-.24-.37a9.86 9.86 0 0 1-1.52-5.25c0-5.46 4.45-9.91 9.92-9.91 2.64 0 5.13 1.03 7 2.9a9.85 9.85 0 0 1 2.9 7c0 5.46-4.45 9.88-9.93 9.88Zm5.44-7.41c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.17.2-.35.22-.65.07-.3-.15-1.25-.46-2.38-1.46-.88-.78-1.47-1.75-1.64-2.05-.17-.3-.02-.46.13-.61.14-.13.3-.35.45-.52.15-.18.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.48-.5-.67-.51h-.57c-.2 0-.52.08-.8.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.87 1.22 3.07c.15.2 2.1 3.2 5.08 4.48.71.3 1.26.49 1.69.63.71.23 1.36.2 1.87.12.57-.08 1.76-.72 2.01-1.42.25-.7.25-1.29.17-1.42-.07-.13-.27-.2-.57-.35Z"/>
            </svg>
        </a>
    @endif
    {{-- FOOTER --}}
    <footer class="border-t border-slate-200 py-8 dark:border-slate-700">
        <div class="container-main text-center">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                © {{ date('Y') }} {{ $siteSetting->site_name }}. All rights reserved.
            </p>
        </div>
    </footer>
@endsection
