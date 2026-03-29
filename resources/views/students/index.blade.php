@extends('students.layout')

@section('page-title', 'Students')
@section('page-subtitle', 'Roster')

@section('content')
@php
    $selectedProgram = request('program') ? $programs->firstWhere('id', (int) request('program')) : null;
    $activeFilters = collect([
        request('search') ? request('search') : null,
        request('status') ? request('status') : null,
        $selectedProgram ? $selectedProgram->code : null,
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

<section class="surface-panel p-5">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="section-kicker">Roster</p>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Student records</h2>
        </div>

        <div class="flex flex-wrap gap-2">
            <span class="metric-pill">{{ $stats['total'] }} total</span>
            <span class="metric-pill">{{ $stats['active'] }} active</span>
            <span class="metric-pill">{{ $programs->count() }} programs</span>
            @if($activeFilters->isNotEmpty())
                @foreach($activeFilters as $filter)
                    <span class="metric-pill">{{ $filter }}</span>
                @endforeach
            @endif
        </div>
    </div>

    <form method="GET" action="{{ route('students.index') }}" class="mt-5 grid gap-4 xl:grid-cols-[minmax(0,1.35fr)_220px_220px_auto]">
        <div class="field-group">
            <label for="student-search" class="field-label">Search</label>
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
                        {{ $program->code }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end gap-3">
            <button type="submit" class="btn btn-primary w-full xl:w-auto">Apply</button>
            @if($activeFilters->isNotEmpty())
                <a href="{{ route('students.index') }}" class="btn btn-secondary w-full xl:w-auto">Reset</a>
            @endif
        </div>
    </form>
</section>

@if($students->isEmpty())
    <section class="surface-panel empty-state">
        <p class="section-kicker">No results</p>
        <h3 class="text-2xl font-semibold tracking-tight text-slate-950">No matching students.</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Reset</a>
            <a href="{{ route('students.create') }}" class="btn btn-primary">Add student</a>
        </div>
    </section>
@else
    <section class="surface-panel data-shell">
        <div class="flex flex-col gap-4 border-b border-slate-900/8 p-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="section-kicker">List</p>
                <h3 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Students</h3>
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
                            <p class="mt-1 text-sm text-slate-500">{{ $student->program->code }}</p>
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
                            <span class="data-point-value text-sm">{{ $student->program->name }}</span>
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
                <p class="text-sm text-slate-600">Page {{ $students->currentPage() }} of {{ $students->lastPage() }}</p>
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
