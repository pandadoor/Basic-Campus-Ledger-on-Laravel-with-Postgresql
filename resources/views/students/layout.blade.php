<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Dashboard') - Campus Ledger</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $contextAction = match (true) {
        request()->routeIs('admin.index') => [
            'href' => route('students.create'),
            'label' => 'Add student',
            'icon' => 'M12 4v16m8-8H4',
            'variant' => 'btn-primary',
        ],
        request()->routeIs('students.index') => [
            'href' => route('students.create'),
            'label' => 'Add student',
            'icon' => 'M12 4v16m8-8H4',
            'variant' => 'btn-primary',
        ],
        request()->routeIs('students.create', 'students.edit', 'students.show') => [
            'href' => route('students.index'),
            'label' => 'All students',
            'icon' => 'M10.25 6.75L4.75 12l5.5 5.25M19.25 12H5',
            'variant' => 'btn-secondary',
        ],
        request()->routeIs('programs.index') => [
            'href' => route('programs.create'),
            'label' => 'New program',
            'icon' => 'M12 4v16m8-8H4',
            'variant' => 'btn-primary',
        ],
        request()->routeIs('programs.create', 'programs.edit') => [
            'href' => route('programs.index'),
            'label' => 'All programs',
            'icon' => 'M10.25 6.75L4.75 12l5.5 5.25M19.25 12H5',
            'variant' => 'btn-secondary',
        ],
        request()->routeIs('courses.index') => [
            'href' => route('courses.create'),
            'label' => 'New course',
            'icon' => 'M12 4v16m8-8H4',
            'variant' => 'btn-primary',
        ],
        request()->routeIs('courses.create', 'courses.edit') => [
            'href' => route('courses.index'),
            'label' => 'All courses',
            'icon' => 'M10.25 6.75L4.75 12l5.5 5.25M19.25 12H5',
            'variant' => 'btn-secondary',
        ],
        default => null,
    };
@endphp
<body class="app-body">
<div class="relative min-h-screen lg:grid lg:grid-cols-[15rem_minmax(0,1fr)]">
    <aside id="app-sidebar" class="app-sidebar fixed inset-y-0 left-0 z-50 flex w-[15rem] max-w-[86vw] shrink-0 -translate-x-full flex-col transition-transform duration-300 lg:relative lg:z-10 lg:min-h-screen lg:w-auto lg:max-w-none lg:translate-x-0">
        <div class="relative z-10 px-6 pb-6 pt-6">
            <div class="flex items-center gap-4">
                <div class="sidebar-brand-mark">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4l8 4-8 4-8-4 8-4z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 12l8 4 8-4"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l8 4 8-4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-lg font-semibold tracking-tight text-white">Campus Ledger</p>
                    <p class="mt-1 text-base leading-7 text-white/58">Student operations with a cleaner daily flow.</p>
                </div>
            </div>
        </div>

        <nav class="relative z-10 flex-1 overflow-y-auto px-3 pb-6 lg:overflow-visible" aria-label="Primary navigation">
            <div class="mb-6">
                <p class="nav-kicker">Overview</p>
                <div class="space-y-2">
                    <a href="{{ route('admin.index') }}"
                       class="nav-link {{ request()->routeIs('admin.index') ? 'is-active' : '' }}"
                       aria-current="{{ request()->routeIs('admin.index') ? 'page' : 'false' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 13h7V4H4v9zm9 7h7V4h-7v16zM4 20h7v-5H4v5z"/>
                        </svg>
                        <span class="flex-1">Dashboard</span>
                    </a>
                </div>
            </div>

            <div class="mb-6">
                <p class="nav-kicker">Student workspace</p>
                <div class="space-y-2">
                    <a href="{{ route('students.index') }}"
                       class="nav-link {{ request()->routeIs('students.index', 'students.show', 'students.edit') ? 'is-active' : '' }}"
                       aria-current="{{ request()->routeIs('students.index', 'students.show', 'students.edit') ? 'page' : 'false' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.36-1.86M17 20H7m10 0v-2c0-.65-.13-1.28-.36-1.86M7 20H2v-2a3 3 0 015.36-1.86M7 20v-2c0-.65.13-1.28.36-1.86m0 0a5 5 0 019.28 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="flex-1">Roster</span>
                    </a>

                    <a href="{{ route('students.create') }}"
                       class="nav-link {{ request()->routeIs('students.create') ? 'is-active' : '' }}"
                       aria-current="{{ request()->routeIs('students.create') ? 'page' : 'false' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span class="flex-1">New student</span>
                    </a>
                </div>
            </div>

            <div class="mb-6">
                <p class="nav-kicker">Reference data</p>
                <div class="space-y-2">
                    <a href="{{ route('programs.index') }}"
                       class="nav-link {{ request()->routeIs('programs.*') ? 'is-active' : '' }}"
                       aria-current="{{ request()->routeIs('programs.*') ? 'page' : 'false' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 7h14M5 12h14M5 17h14"/>
                        </svg>
                        <span class="flex-1">Programs</span>
                    </a>

                    <a href="{{ route('courses.index') }}"
                       class="nav-link {{ request()->routeIs('courses.*') ? 'is-active' : '' }}"
                       aria-current="{{ request()->routeIs('courses.*') ? 'page' : 'false' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.75 6.75A16.58 16.58 0 0112 5c2.74 0 5.34.66 7.25 1.75v11.5A16.58 16.58 0 0012 17c-2.74 0-5.34.66-7.25 1.75V6.75z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 5v12"/>
                        </svg>
                        <span class="flex-1">Courses</span>
                    </a>
                </div>
            </div>

            <div class="mt-6 rounded-2xl border border-white/8 bg-white/4 px-4 py-4">
                <p class="text-xs uppercase tracking-[0.24em] text-white/40">Workspace</p>
                <p class="mt-3 text-sm leading-7 text-white/68">Admin dashboard for quick adds, with focused roster and catalog pages when you need detail.</p>
            </div>
        </nav>

        <div class="relative z-10 px-3 pb-5 pt-1">
            <div class="rounded-2xl border border-white/8 bg-white/4 px-4 py-4">
                <p class="text-xs uppercase tracking-[0.24em] text-white/40">Stack</p>
                <div class="mt-3 flex items-center justify-between gap-3">
                    <p class="font-data text-sm text-white/72">Laravel / PostgreSQL</p>
                    <span class="rounded-full border border-white/10 bg-white/6 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.24em] text-white/60">Ready</span>
                </div>
            </div>
        </div>
    </aside>

    <div id="app-sidebar-backdrop" class="fixed inset-0 z-40 hidden bg-slate-950/45 backdrop-blur-sm lg:hidden" onclick="toggleSidebar(false)"></div>

    <div class="flex min-w-0 flex-col">
        <header class="app-topbar sticky top-0 z-30">
            <div class="flex w-full items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-7">
                <div class="flex min-w-0 items-center gap-3">
                    <button type="button"
                            class="icon-btn lg:hidden"
                            onclick="toggleSidebar()"
                            aria-label="Toggle sidebar">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M4 12h16M4 17h16"/>
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <p class="section-kicker">Campus Ledger</p>
                        <h1 class="text-xl font-semibold tracking-tight text-slate-950 sm:text-2xl">@yield('page-title', 'Dashboard')</h1>
                        <p class="mt-1 hidden text-base text-slate-500 sm:block">@yield('page-subtitle', 'A clearer view of student operations.')</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="page-count-chip hidden sm:inline-flex">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ now()->format('M d, Y') }}</span>
                    </div>

                    @if($contextAction)
                        <a href="{{ $contextAction['href'] }}" class="btn {{ $contextAction['variant'] }}">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $contextAction['icon'] }}"/>
                            </svg>
                            <span class="hidden sm:inline">{{ $contextAction['label'] }}</span>
                            <span class="sm:hidden">Open</span>
                        </a>
                    @endif
                </div>
            </div>
        </header>

        <main class="flex-1">
            <div class="page-shell space-y-5">
                @if(session('success'))
                    <div class="flash-banner flash-banner--success" role="alert">
                        <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 13l4 4L19 7"/>
                        </svg>
                        <div>
                            <p class="font-semibold">Update completed</p>
                            <p class="mt-1 text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="flash-banner flash-banner--danger" role="alert">
                        <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <div>
                            <p class="font-semibold">Action needs attention</p>
                            <p class="mt-1 text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</div>

<script>
    const sidebar = document.getElementById('app-sidebar');
    const backdrop = document.getElementById('app-sidebar-backdrop');

    function toggleSidebar(forceOpen) {
        const shouldOpen = typeof forceOpen === 'boolean'
            ? forceOpen
            : sidebar.classList.contains('-translate-x-full');

        sidebar.classList.toggle('-translate-x-full', !shouldOpen);
        backdrop.classList.toggle('hidden', !shouldOpen);
    }

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.add('hidden');
        } else if (!backdrop.classList.contains('hidden')) {
            sidebar.classList.remove('-translate-x-full');
        } else {
            sidebar.classList.add('-translate-x-full');
        }
    });
</script>
</body>
</html>
