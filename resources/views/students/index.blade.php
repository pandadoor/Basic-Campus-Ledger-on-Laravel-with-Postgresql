@extends('students.layout')

@section('page-title', 'Students')
@section('page-subtitle', 'Search, review, and update every student record from one roster.')

@section('content')
@php
    $selectedProgram = request('program') ? $programs->firstWhere('id', (int) request('program')) : null;
    $activeFilters = collect([
        request('search') ? 'Search: ' . request('search') : null,
        request('status') ? 'Status: ' . request('status') : null,
        $selectedProgram ? 'Program: ' . $selectedProgram->code : null,
    ])->filter()->values();

    $statusStyles = [
        'Active' => 'status-badge status-badge--success',
        'Graduated' => 'status-badge status-badge--info',
        'On Leave' => 'status-badge status-badge--warning',
        'Inactive' => 'status-badge status-badge--muted',
    ];

    $resultsFrom = $students->firstItem() ?? 0;
    $resultsTo = $students->lastItem() ?? 0;
@endphp

<div class="grid gap-6 xl:grid-cols-[minmax(0,1.35fr)_340px]">
    <section class="surface-panel hero-panel">
        <p class="section-kicker">Enrollment command center</p>
        <h2 class="section-title mt-4">See the whole roster, then move straight into action.</h2>
        <p class="section-copy mt-4">The new dashboard keeps filtering, student context, and next actions in one visual rhythm so daily roster work feels lighter and faster.</p>

        <div class="mt-6 flex flex-wrap gap-3">
            <span class="metric-pill">{{ $stats['total'] }} total students</span>
            <span class="metric-pill">{{ $programs->count() }} programs available</span>
            <span class="metric-pill">{{ $statuses->count() }} tracked status states</span>
        </div>
    </section>

    <section class="surface-panel p-6">
        <p class="section-kicker">Current slice</p>
        @if($activeFilters->isNotEmpty())
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach($activeFilters as $filter)
                    <span class="metric-pill">{{ $filter }}</span>
                @endforeach
            </div>
        @else
            <p class="mt-4 text-sm leading-7 text-slate-600">No filters are active right now, so you are looking at the full student roster.</p>
        @endif

        <div class="summary-list mt-6">
            <div class="summary-item">
                <div>
                    <p class="text-sm font-semibold text-slate-950">Visible records</p>
                    <p class="mt-1 text-sm text-slate-500">Students on this page right now</p>
                </div>
                <span class="font-data text-sm text-slate-700">{{ $students->count() }}</span>
            </div>
            <div class="summary-item">
                <div>
                    <p class="text-sm font-semibold text-slate-950">Pagination</p>
                    <p class="mt-1 text-sm text-slate-500">Current reading position</p>
                </div>
                <span class="font-data text-sm text-slate-700">{{ $students->currentPage() }}/{{ max($students->lastPage(), 1) }}</span>
            </div>
            <div class="summary-item">
                <div>
                    <p class="text-sm font-semibold text-slate-950">Result range</p>
                    <p class="mt-1 text-sm text-slate-500">Current slice of the full roster</p>
                </div>
                <span class="font-data text-sm text-slate-700">{{ $resultsFrom }}-{{ $resultsTo }}</span>
            </div>
        </div>
    </section>
</div>

<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    @foreach([
        ['label' => 'Total students', 'value' => $stats['total'], 'copy' => 'Every record currently in the roster', 'accent' => 'rgba(16, 37, 66, 0.18)'],
        ['label' => 'Active', 'value' => $stats['active'], 'copy' => 'Students progressing through the current term', 'accent' => 'rgba(15, 118, 110, 0.18)'],
        ['label' => 'Graduated', 'value' => $stats['graduated'], 'copy' => 'Completed records still tracked for history', 'accent' => 'rgba(37, 99, 235, 0.18)'],
        ['label' => 'Inactive / leave', 'value' => $stats['inactive'], 'copy' => 'Records needing follow-up or status review', 'accent' => 'rgba(217, 119, 6, 0.18)'],
    ] as $stat)
        <article class="stat-card" style="--card-accent: {{ $stat['accent'] }}">
            <p class="stat-kicker">{{ $stat['label'] }}</p>
            <p class="stat-value font-data">{{ $stat['value'] }}</p>
            <p class="stat-copy">{{ $stat['copy'] }}</p>
        </article>
    @endforeach
</div>

<section class="surface-panel p-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="section-kicker">Search and refine</p>
            <h3 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Zero in on the students you need.</h3>
            <p class="mt-2 max-w-2xl text-sm leading-7 text-slate-600">Search by name, student ID, or email, then narrow the roster by status or program without leaving the page.</p>
        </div>

        @if($activeFilters->isNotEmpty())
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Clear filters</a>
        @endif
    </div>

    <form method="GET" action="{{ route('students.index') }}" class="mt-6 grid gap-4 xl:grid-cols-[minmax(0,1.35fr)_220px_220px_auto]">
        <div class="field-group">
            <label for="student-search" class="field-label">Search roster</label>
            <input
                id="student-search"
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Name, student ID, or email"
                class="text-input"
            >
        </div>

        <div class="field-group">
            <label for="status-filter" class="field-label">Status</label>
            <select id="status-filter" name="status" class="select-input">
                <option value="">All statuses</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->name }}" {{ request('status') === $status->name ? 'selected' : '' }}>{{ $status->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="field-group">
            <label for="program-filter" class="field-label">Program</label>
            <select id="program-filter" name="program" class="select-input">
                <option value="">All programs</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}" {{ (string) request('program') === (string) $program->id ? 'selected' : '' }}>
                        {{ $program->code }} / {{ $program->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end">
            <button type="submit" class="btn btn-primary w-full xl:w-auto">Apply filters</button>
        </div>
    </form>
</section>

@if($students->isEmpty())
    <section class="surface-panel empty-state">
        <p class="section-kicker">No matching records</p>
        <h3 class="text-2xl font-semibold tracking-tight text-slate-950">No students matched the current search.</h3>
        <p class="max-w-xl text-sm leading-7 text-slate-600">Try clearing the filters or start the roster by adding a new student record.</p>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Reset filters</a>
            <a href="{{ route('students.create') }}" class="btn btn-primary">Add student</a>
        </div>
    </section>
@else
    <section class="surface-panel data-shell">
        <div class="flex flex-col gap-4 border-b border-slate-900/8 p-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="section-kicker">Roster view</p>
                <h3 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Student records</h3>
                <p class="mt-2 text-sm leading-7 text-slate-600">Sorted by newest record first. Open a profile to review full details or jump straight into editing.</p>
            </div>
            <span class="page-count-chip">Showing {{ $resultsFrom }}-{{ $resultsTo }} of {{ $students->total() }}</span>
        </div>

        <div class="space-y-4 p-4 md:hidden">
            @foreach($students as $student)
                @php
                    $statusClass = $statusStyles[$student->status->name] ?? 'status-badge status-badge--muted';
                @endphp
                <article class="record-card p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <span class="code-pill">{{ $student->student_id }}</span>
                            <h4 class="mt-3 text-lg font-semibold tracking-tight text-slate-950">{{ $student->full_name }}</h4>
                            <p class="mt-1 text-sm text-slate-500">{{ $student->program->code }} / {{ $student->program->name }}</p>
                        </div>
                        <span class="{{ $statusClass }}">{{ $student->status->name }}</span>
                    </div>

                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <div class="data-point">
                            <span class="data-point-label">Email</span>
                            <span class="data-point-value font-data text-sm">{{ $student->email }}</span>
                        </div>
                        <div class="data-point">
                            <span class="data-point-label">Enrolled</span>
                            <span class="data-point-value font-data text-sm">{{ \Illuminate\Support\Carbon::parse($student->enrollment_date)->format('M d, Y') }}</span>
                        </div>
                        <div class="data-point">
                            <span class="data-point-label">Gender</span>
                            <span class="data-point-value text-sm">{{ $student->gender->name }}</span>
                        </div>
                        <div class="data-point">
                            <span class="data-point-label">Program</span>
                            <span class="data-point-value text-sm">{{ $student->program->code }}</span>
                        </div>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <a href="{{ route('students.show', $student) }}" class="btn btn-secondary">View</a>
                        <a href="{{ route('students.edit', $student) }}" class="btn btn-ghost">Edit</a>
                        <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Delete {{ addslashes($student->full_name) }}? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="hidden overflow-x-auto md:block">
            <table class="data-table" aria-label="Students list">
                <thead>
                    <tr>
                        <th scope="col">Student ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Program</th>
                        <th scope="col">Email</th>
                        <th scope="col">Enrolled</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        @php
                            $statusClass = $statusStyles[$student->status->name] ?? 'status-badge status-badge--muted';
                        @endphp
                        <tr>
                            <td><span class="code-pill">{{ $student->student_id }}</span></td>
                            <td>
                                <p class="font-semibold text-slate-950">{{ $student->full_name }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $student->gender->name }}</p>
                            </td>
                            <td>
                                <p class="font-medium text-slate-900">{{ $student->program->code }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $student->program->name }}</p>
                            </td>
                            <td class="font-data text-sm text-slate-700">{{ $student->email }}</td>
                            <td class="font-data text-sm text-slate-700">{{ \Illuminate\Support\Carbon::parse($student->enrollment_date)->format('M d, Y') }}</td>
                            <td><span class="{{ $statusClass }}">{{ $student->status->name }}</span></td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('students.show', $student) }}" class="icon-btn" title="View {{ $student->full_name }}" aria-label="View {{ $student->full_name }}">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.46 12c1.27-4.06 5.06-7 9.54-7s8.27 2.94 9.54 7c-1.27 4.06-5.06 7-9.54 7s-8.27-2.94-9.54-7z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('students.edit', $student) }}" class="icon-btn" title="Edit {{ $student->full_name }}" aria-label="Edit {{ $student->full_name }}">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.5 3.5a2.12 2.12 0 013 3L12 16l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Delete {{ addslashes($student->full_name) }}? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-btn text-rose-700" title="Delete {{ $student->full_name }}" aria-label="Delete {{ $student->full_name }}">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.87 12.14A2 2 0 0116.14 21H7.86a2 2 0 01-1.99-1.86L5 7"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 11v6M14 11v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
            <div class="pagination-bar">
                <p class="text-sm text-slate-600">Page {{ $students->currentPage() }} of {{ $students->lastPage() }}. Showing {{ $resultsFrom }}-{{ $resultsTo }} out of {{ $students->total() }} students.</p>
                <div class="flex flex-wrap gap-3">
                    @if($students->onFirstPage())
                        <span class="btn btn-ghost opacity-50">Previous</span>
                    @else
                        <a href="{{ $students->previousPageUrl() }}" class="btn btn-secondary">Previous</a>
                    @endif

                    @if($students->hasMorePages())
                        <a href="{{ $students->nextPageUrl() }}" class="btn btn-primary">Next</a>
                    @else
                        <span class="btn btn-ghost opacity-50">Next</span>
                    @endif
                </div>
            </div>
        @endif
    </section>
@endif
@endsection
