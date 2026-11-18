<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Login | Natan Development</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen items-center justify-center bg-slate-100 px-5 py-10">

    <div class="w-full max-w-md">

        <!-- Logo -->
        <div class="mb-8 text-center">
            <a href="{{ url('/') }}"
               class="inline-flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#111827] text-2xl font-bold text-white">
                    N
                </div>

                <span class="font-heading text-2xl font-bold text-slate-900">
                    Natan<span class="text-amber-500">.</span>
                </span>
            </a>

            <p class="mt-3 text-sm text-slate-500">
                Administration Panel
            </p>
        </div>

        <!-- Login Card -->
        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-xl shadow-slate-200/50 sm:p-10">

            <div class="mb-8">
                <h1 class="font-heading text-2xl font-bold text-slate-900">
                    Welcome Back!
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Sign in to access your administration dashboard.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('status'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login.store') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="mb-5">
                    <label for="email"
                           class="mb-2 block text-sm font-semibold text-slate-700">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="admin@example.com"
                        autocomplete="username"
                        required
                        autofocus
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-amber-400 focus:bg-white focus:ring-4 focus:ring-amber-400/10"
                    >
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <div class="mb-2 flex items-center justify-between">
                        <label for="password"
                               class="block text-sm font-semibold text-slate-700">
                            Password
                        </label>
                    </div>

                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-16 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-amber-400 focus:bg-white focus:ring-4 focus:ring-amber-400/10"
                        >

                        <button
                            type="button"
                            id="toggle-password"
                            class="absolute inset-y-0 right-4 text-xs font-semibold text-slate-500 hover:text-amber-600"
                        >
                            Show
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="mb-7 flex items-center">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        value="1"
                        class="h-4 w-4 rounded border-slate-300 accent-amber-400"
                    >

                    <label for="remember"
                           class="ml-2 text-sm text-slate-600">
                        Remember me
                    </label>
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full rounded-xl bg-amber-400 px-5 py-3.5 text-sm font-bold text-slate-900 transition hover:-translate-y-0.5 hover:bg-amber-300 hover:shadow-lg hover:shadow-amber-400/20"
                >
                    Sign In
                    <span class="ml-2">→</span>
                </button>

            </form>
        </div>

        <p class="mt-8 text-center text-xs text-slate-400">
            © {{ date('Y') }} Natan Development. All rights reserved.
        </p>

    </div>

</body>
</html>
