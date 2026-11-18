
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') | {{ $siteSetting->site_name }} Admin</title>

    @if($siteSetting->site_favicon)
        <link rel="icon" href="{{ asset('storage/' . $siteSetting->site_favicon) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

    <!-- Mobile Overlay -->
    <div id="admin-overlay"
         class="fixed inset-0 z-40 hidden bg-slate-950/50 lg:hidden">
    </div>

    <!-- Sidebar -->
    <aside id="admin-sidebar"
        class="fixed inset-y-0 left-0 z-50 flex h-dvh w-64 -translate-x-full flex-col bg-[#111827] text-white transition-transform duration-300 lg:translate-x-0">

        <!-- Dynamic Website Logo -->
        <div class="flex h-20 shrink-0 items-center gap-3 border-b border-white/10 px-6">

            @if($siteSetting->site_logo)
                <img
                    src="{{ asset('storage/' . $siteSetting->site_logo) }}"
                    alt="{{ $siteSetting->site_name }}"
                    class="h-10 w-10 shrink-0 rounded-xl bg-white object-contain p-1"
                >
            @else
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-xl font-bold text-[#111827]">
                    {{ strtoupper(substr($siteSetting->site_name, 0, 1)) }}
                </div>
            @endif

            <div class="min-w-0">
                <h1 class="truncate font-heading text-lg font-bold">
                    {{ $siteSetting->site_name }}
                </h1>
                <p class="text-xs text-slate-400">Administration Panel</p>
            </div>

        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-7 overflow-y-auto px-4 py-7">

            <!-- Main Menu -->
            <div>
                <p class="mb-3 px-3 text-[11px] font-bold uppercase tracking-widest text-slate-500">
                    Main Menu
                </p>

                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                       @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif
                       class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'admin-nav-link-active' : '' }}">

                        <span>▦</span>
                        Dashboard
                    </a>
                </div>
            </div>

            <!-- Website Management -->
            <div>
                <p class="mb-3 px-3 text-[11px] font-bold uppercase tracking-widest text-slate-500">
                    Website Management
                </p>

                <div class="space-y-1">

                    {{-- SKILLS DROPDOWN --}}
                    @php
                        $isSkillsMenuActive = request()->routeIs(
                            'admin.skills.*',
                            'admin.skills-categories.*'
                        );
                    @endphp

                    <div class="space-y-1">

                        <button
                            type="button"
                            id="skills-dropdown-button"
                            aria-expanded="{{ $isSkillsMenuActive ? 'true' : 'false' }}"
                            aria-controls="skills-dropdown-menu"
                            class="flex w-full cursor-pointer items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold transition
                            {{ $isSkillsMenuActive
                                ? 'text-amber-400'
                                : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3l1.9 5.8L20 11l-6.1 2.2L12 19l-1.9-5.8L4 11l6.1-2.2L12 3z"
                                />
                            </svg>

                            <span>Skills</span>

                            <svg
                                id="skills-dropdown-icon"
                                class="ml-auto h-4 w-4 transition-transform duration-200 {{ $isSkillsMenuActive ? 'rotate-180' : '' }}"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7"/>
                            </svg>
                        </button>

                        <div
                            id="skills-dropdown-menu"
                            class="{{ $isSkillsMenuActive ? '' : 'hidden' }} ml-5 space-y-1 border-l border-white/10 pl-4"
                        >

                            <a
                                href="{{ route('admin.skills.index') }}"
                                @if(request()->routeIs('admin.skills.index')) aria-current="page" @endif
                                class="block rounded-lg px-3 py-2 text-sm transition
                                {{ request()->routeIs('admin.skills.index')
                                    ? 'bg-white/10 font-semibold text-amber-400'
                                    : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"
                            >
                                Manage Skills
                            </a>

                            <a
                                href="{{ route('admin.skills-categories.index') }}"
                                @if(request()->routeIs('admin.skills-categories.*')) aria-current="page" @endif
                                class="block rounded-lg px-3 py-2 text-sm transition
                                {{ request()->routeIs('admin.skills-categories.*')
                                    ? 'bg-white/10 font-semibold text-amber-400'
                                    : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"
                            >
                                Manage Categories
                            </a>

                        </div>
                    </div>


                    {{-- PROJECTS DROPDOWN --}}
                    @php
                        $isProjectsMenuActive = request()->routeIs(
                            'admin.projects.*',
                            'admin.project-categories.*'
                        );
                    @endphp

                    <div class="space-y-1">

                        <button
                            type="button"
                            id="projects-dropdown-button"
                            aria-expanded="{{ $isProjectsMenuActive ? 'true' : 'false' }}"
                            aria-controls="projects-dropdown-menu"
                            class="flex w-full cursor-pointer items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold transition
                            {{ $isProjectsMenuActive
                                ? 'text-amber-400'
                                : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 7.5A1.5 1.5 0 014.5 6h5l2 2h8A1.5 1.5 0 0121 9.5v9a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 013 18.5v-11z"
                                />
                            </svg>

                            <span>Projects</span>

                            <svg
                                id="projects-dropdown-icon"
                                class="ml-auto h-4 w-4 transition-transform duration-200 {{ $isProjectsMenuActive ? 'rotate-180' : '' }}"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>
                        </button>

                        <div
                            id="projects-dropdown-menu"
                            class="{{ $isProjectsMenuActive ? '' : 'hidden' }} ml-5 space-y-1 border-l border-white/10 pl-4"
                        >

                            <a
                                href="{{ route('admin.projects.index') }}"
                                @if(request()->routeIs('admin.projects.*')) aria-current="page" @endif
                                class="block rounded-lg px-3 py-2 text-sm transition
                                {{ request()->routeIs('admin.projects.*')
                                    ? 'bg-white/10 font-semibold text-amber-400'
                                    : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"
                            >
                                Manage Projects
                            </a>

                            <a
                                href="{{ route('admin.project-categories.index') }}"
                                @if(request()->routeIs('admin.project-categories.*')) aria-current="page" @endif
                                class="block rounded-lg px-3 py-2 text-sm transition
                                {{ request()->routeIs('admin.project-categories.*')
                                    ? 'bg-white/10 font-semibold text-amber-400'
                                    : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"
                            >
                                Manage Categories
                            </a>

                        </div>
                    </div>

                    <a href="{{ url('/admin/experiences') }}"
                       @if(request()->is('admin/experiences*')) aria-current="page" @endif
                       class="admin-nav-link {{ request()->is('admin/experiences*') ? 'admin-nav-link-active' : '' }}">
                        <span>▤</span>
                        Experience
                    </a>

                    <a href="{{ url('/admin/educations') }}"
                       @if(request()->is('admin/educations*')) aria-current="page" @endif
                       class="admin-nav-link {{ request()->is('admin/educations*') ? 'admin-nav-link-active' : '' }}">
                        <span>▥</span>
                        Educations
                    </a>

                </div>
            </div>

            <!-- Communication -->
            <div>
                {{-- <p class="mb-3 px-3 text-[11px] font-bold uppercase tracking-widest text-slate-500">
                    Communication
                </p>

                <a href="{{ url('/admin/messages') }}"
                   @if(request()->is('admin/messages*')) aria-current="page" @endif
                   class="admin-nav-link {{ request()->is('admin/messages*') ? 'admin-nav-link-active' : '' }}">
                    <span>✉</span>
                    Messages
                </a> --}}
            </div>

        </nav>

    </aside>

    <!-- Main Content -->
    <div class="min-h-screen lg:pl-64">

        <!-- Topbar -->
        <header class="sticky top-0 z-30 flex h-20 items-center justify-between border-b border-slate-200 bg-white/95 px-5 backdrop-blur sm:px-8">

            <div class="flex min-w-0 items-center gap-4">

                <button id="admin-menu-button"
                    type="button"
                    aria-label="Open navigation menu"
                    aria-expanded="false"
                    aria-controls="admin-sidebar"
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 text-xl hover:bg-slate-100 lg:hidden">
                    ☰
                </button>

                <div class="min-w-0">
                    <h2 class="truncate font-heading text-lg font-bold text-slate-900">
                        @yield('page-title', 'Dashboard')
                    </h2>

                    <p class="hidden truncate text-xs text-slate-500 sm:block">
                        @yield('page-description', 'Welcome to your administration panel.')
                    </p>
                </div>

            </div>

            <div class="flex shrink-0 items-center gap-3">

                <a href="{{ route('home') }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="hidden text-sm font-medium text-slate-500 transition hover:text-amber-600 sm:block">
                    View Website ↗
                </a>

                <!-- Administrator Profile Dropdown -->
                <div class="relative">

                    <button
                        type="button"
                        id="admin-profile-button"
                        aria-expanded="false"
                        aria-controls="admin-profile-menu"
                        class="flex items-center gap-3 rounded-xl border border-transparent px-2 py-1.5 transition hover:border-slate-200 hover:bg-slate-50"
                    >
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-100 font-bold text-amber-700">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>

                        <span class="hidden text-left sm:block">
                            <span class="block text-sm font-semibold text-slate-800">
                                {{ auth()->user()->name }}
                            </span>
                            <span class="block text-xs text-slate-500">
                                Administrator
                            </span>
                        </span>

                        <svg
                            id="admin-profile-icon"
                            class="h-4 w-4 text-slate-500 transition-transform duration-200"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div
                        id="admin-profile-menu"
                        class="absolute right-0 top-full z-50 mt-3 hidden w-60 overflow-hidden rounded-xl border border-slate-200 bg-white py-2 shadow-xl"
                    >

                        <div class="border-b border-slate-100 px-4 py-3">
                            <p class="truncate text-sm font-semibold text-slate-800">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="truncate text-xs text-slate-500">
                                {{ auth()->user()->email }}
                            </p>
                        </div>

                        <a
                            href="{{ route('admin.profile.edit') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-slate-600 transition hover:bg-slate-50 hover:text-slate-900"
                        >
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0"/>
                            </svg>
                            My Profile
                        </a>

                        <a
                            href="{{ route('admin.settings.edit') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-slate-600 transition hover:bg-slate-50 hover:text-slate-900"
                        >
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.3 3.7l.4-1.2h2.6l.4 1.2a2 2 0 002.4 1.1l1.2-.4 1.3 2.3-1 .9a2 2 0 000 2.8l1 .9-1.3 2.3-1.2-.4a2 2 0 00-2.4 1.1l-.4 1.2h-2.6l-.4-1.2a2 2 0 00-2.4-1.1l-1.2.4-1.3-2.3 1-.9a2 2 0 000-2.8l-1-.9 1.3-2.3 1.2.4a2 2 0 002.4-1.1z"/>
                                <circle cx="12" cy="9" r="2.5"/>
                            </svg>
                            Website Settings
                        </a>

                        <div class="my-2 border-t border-slate-100"></div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf

                            <button
                                type="submit"
                                class="flex w-full items-center gap-3 px-4 py-3 text-sm font-medium text-red-600 transition hover:bg-red-50"
                            >
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M18 15l3-3m0 0l-3-3m3 3H9"/>
                                </svg>
                                Logout
                            </button>
                        </form>

                    </div>
                </div>

            </div>

        </header>

        <!-- Page Content -->
        <main class="p-5 sm:p-8">
            <div class="mx-auto max-w-7xl">
                @yield('content')
            </div>
        </main>

    </div>

</body>
</html>
