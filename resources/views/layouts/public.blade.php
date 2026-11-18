<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="{{ $siteSetting->site_description ?? 'Full Stack Web Developer Portfolio' }}">

    <title>@yield('title', $siteSetting->site_name) | Building Digital Experiences</title>

    @if($siteSetting->site_favicon)
        <link rel="icon" href="{{ asset('storage/' . $siteSetting->site_favicon) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white text-slate-900 antialiased transition-colors duration-300 dark:bg-[#111827] dark:text-white">

    @yield('content')

</body>
</html>
