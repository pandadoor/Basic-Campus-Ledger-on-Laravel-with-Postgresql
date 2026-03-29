<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Dashboard') - Campus Ledger</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $contextAction = match (true) {
        request()->routeIs('admin.index', 'students.index') => [
            'href' => route('students.create'),
            'label' => 'Add student',
            'mobile_label' => 'Add',
            'icon' => 'M12 4v16m8-8H4',
            'variant' => 'btn-primary',
        ],
        request()->routeIs('students.create', 'students.edit', 'students.show') => [
            'href' => route('students.index'),
            'label' => 'All students',
            'mobile_label' => 'Back',
            'icon' => 'M10.25 6.75L4.75 12l5.5 5.25M19.25 12H5',
            'variant' => 'btn-secondary',
        ],
        request()->routeIs('programs.index') => [
            'href' => route('programs.create'),
            'label' => 'New program',
            'mobile_label' => 'New',
            'icon' => 'M12 4v16m8-8H4',
            'variant' => 'btn-primary',
        ],
        request()->routeIs('programs.create', 'programs.edit') => [
            'href' => route('programs.index'),
            'label' => 'All programs',
            'mobile_label' => 'Back',
            'icon' => 'M10.25 6.75L4.75 12l5.5 5.25M19.25 12H5',
            'variant' => 'btn-secondary',
        ],
        request()->routeIs('courses.index') => [
            'href' => route('courses.create'),
            'label' => 'New course',
            'mobile_label' => 'New',
            'icon' => 'M12 4v16m8-8H4',
            'variant' => 'btn-primary',
        ],
        request()->routeIs('courses.create', 'courses.edit') => [
            'href' => route('courses.index'),
            'label' => 'All courses',
            'mobile_label' => 'Back',
            'icon' => 'M10.25 6.75L4.75 12l5.5 5.25M19.25 12H5',
            'variant' => 'btn-secondary',
        ],
        default => null,
    };

    $primaryNav = [
        [
            'label' => 'Dashboard',
            'route' => route('admin.index'),
            'match' => ['admin.index'],
            'icon' => [
                'M4 13h7V4H4v9zm9 7h7V4h-7v16zM4 20h7v-5H4v5z',
            ],
        ],
        [
            'label' => 'Students',
            'route' => route('students.index'),
            'match' => ['students.index', 'students.create', 'students.show', 'students.edit'],
            'icon' => [
                'M17 20h5v-2a3 3 0 00-5.36-1.86M17 20H7m10 0v-2c0-.65-.13-1.28-.36-1.86M7 20H2v-2a3 3 0 015.36-1.86M7 20v-2c0-.65.13-1.28.36-1.86m0 0a5 5 0 019.28 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
            ],
        ],
        [
            'label' => 'Programs',
            'route' => route('programs.index'),
            'match' => ['programs.*'],
            'icon' => [
                'M5 7h14M5 12h14M5 17h14',
            ],
        ],
        [
            'label' => 'Courses',
            'route' => route('courses.index'),
            'match' => ['courses.*'],
            'icon' => [
                'M4.75 6.75A16.58 16.58 0 0112 5c2.74 0 5.34.66 7.25 1.75v11.5A16.58 16.58 0 0012 17c-2.74 0-5.34.66-7.25 1.75V6.75z',
                'M12 5v12',
            ],
        ],
    ];

    $matchesRoute = fn (array $patterns) => collect($patterns)->contains(fn ($pattern) => request()->routeIs($pattern));
@endphp
<body class="app-body">
<a href="#main-content" class="skip-link">Skip to main content</a>

<div class="app-frame lg:grid lg:grid-cols-[14rem_minmax(0,1fr)]">
    <aside id="app-sidebar" class="app-sidebar fixed inset-y-0 left-0 z-50 flex w-[14rem] max-w-[88vw] -translate-x-full flex-col overflow-y-auto transition-transform duration-300 lg:sticky lg:top-0 lg:h-screen lg:translate-x-0">
        <div class="sidebar-shell">
            <div class="sidebar-brand">
                <div class="sidebar-brand-mark">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4l8 4-8 4-8-4 8-4z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 12l8 4 8-4"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l8 4 8-4"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-base font-semibold tracking-tight text-white">Campus Ledger</p>
                    <p class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-400">Admin</p>
                </div>
            </div>

            <nav class="sidebar-nav" aria-label="Primary navigation">
                <div class="sidebar-section">
                    <p class="nav-kicker">Workspace</p>
                    <div class="space-y-2">
                        @foreach($primaryNav as $item)
                            @php($isActive = $matchesRoute($item['match']))
                            <a href="{{ $item['route'] }}"
                               data-sidebar-link
                               class="nav-link {{ $isActive ? 'is-active' : '' }}"
                               aria-current="{{ $isActive ? 'page' : 'false' }}">
                                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                    @foreach($item['icon'] as $path)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $path }}"/>
                                    @endforeach
                                </svg>
                                <span class="flex-1">{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </nav>

        </div>
    </aside>

    <div id="app-sidebar-backdrop" class="fixed inset-0 z-40 hidden bg-slate-950/45 backdrop-blur-sm lg:hidden"></div>

    <div class="flex min-w-0 flex-col">
        <header class="app-topbar sticky top-0 z-30">
            <div class="flex w-full items-center justify-between gap-4 px-4 py-4 sm:px-5 lg:px-6">
                <div class="flex min-w-0 items-center gap-3">
                    <button id="sidebar-toggle"
                            type="button"
                            class="icon-btn lg:hidden"
                            aria-controls="app-sidebar"
                            aria-expanded="false"
                            aria-label="Open navigation">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M4 12h16M4 17h16"/>
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <p class="section-kicker">Campus Ledger</p>
                        <h1 class="mt-1 text-xl font-semibold tracking-tight text-slate-950 sm:text-2xl">@yield('page-title', 'Dashboard')</h1>
                    </div>
                </div>

                <div class="flex shrink-0 items-center gap-3">
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
                            <span class="sm:hidden">{{ $contextAction['mobile_label'] }}</span>
                        </a>
                    @endif
                </div>
            </div>
        </header>

        <main id="main-content" class="flex-1">
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

<nav class="mobile-tabbar lg:hidden" aria-label="Mobile navigation">
    @foreach($primaryNav as $item)
        @php($isActive = $matchesRoute($item['match']))
        <a href="{{ $item['route'] }}" class="mobile-tab-link {{ $isActive ? 'is-active' : '' }}" aria-current="{{ $isActive ? 'page' : 'false' }}">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                @foreach($item['icon'] as $path)
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $path }}"/>
                @endforeach
            </svg>
            <span>{{ $item['label'] }}</span>
        </a>
    @endforeach
</nav>

<script>
    const sidebar = document.getElementById('app-sidebar');
    const backdrop = document.getElementById('app-sidebar-backdrop');
    const toggleButton = document.getElementById('sidebar-toggle');
    const closeLinks = document.querySelectorAll('[data-sidebar-link]');

    function setSidebar(open) {
        if (!sidebar || !backdrop) {
            return;
        }

        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.add('hidden');
            document.body.classList.remove('sidebar-open');
            if (toggleButton) {
                toggleButton.setAttribute('aria-expanded', 'false');
            }
            return;
        }

        sidebar.classList.toggle('-translate-x-full', !open);
        backdrop.classList.toggle('hidden', !open);
        document.body.classList.toggle('sidebar-open', open);

        if (toggleButton) {
            toggleButton.setAttribute('aria-expanded', open ? 'true' : 'false');
        }
    }

    function toggleSidebar(forceOpen) {
        const shouldOpen = typeof forceOpen === 'boolean'
            ? forceOpen
            : sidebar.classList.contains('-translate-x-full');

        setSidebar(shouldOpen);
    }

    function syncSidebar() {
        if (!sidebar || !backdrop) {
            return;
        }

        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.add('hidden');
            document.body.classList.remove('sidebar-open');
            if (toggleButton) {
                toggleButton.setAttribute('aria-expanded', 'false');
            }
        } else {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
            document.body.classList.remove('sidebar-open');
            if (toggleButton) {
                toggleButton.setAttribute('aria-expanded', 'false');
            }
        }
    }

    if (toggleButton) {
        toggleButton.addEventListener('click', () => toggleSidebar());
    }

    if (backdrop) {
        backdrop.addEventListener('click', () => setSidebar(false));
    }

    closeLinks.forEach((link) => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 1024) {
                setSidebar(false);
            }
        });
    });

    window.addEventListener('resize', syncSidebar);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setSidebar(false);
        }
    });

    syncSidebar();
</script>
</body>
</html>
