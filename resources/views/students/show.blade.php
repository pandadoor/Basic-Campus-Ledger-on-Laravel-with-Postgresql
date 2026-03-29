@extends('students.layout')

@section('page-title', $student->full_name)
@section('page-subtitle', 'Review the full student profile, placement, and attached courses.')

@section('content')
@php
    $statusClass = match ($student->status->name) {
        'Active' => 'status-badge status-badge--success',
        'Graduated' => 'status-badge status-badge--info',
        'On Leave' => 'status-badge status-badge--warning',
        default => 'status-badge status-badge--muted',
    };
@endphp

<div class="grid gap-6 xl:grid-cols-[minmax(0,1.35fr)_320px]">
    <section class="surface-panel p-6 sm:p-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
            <div class="flex items-start gap-4">
                <div class="avatar-badge">{{ strtoupper(substr($student->first_name, 0, 1)) }}</div>
                <div>
                    <p class="section-kicker">Student profile</p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">{{ $student->full_name }}</h2>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <span class="code-pill">{{ $student->student_id }}</span>
                        <span class="metric-pill">{{ $student->program->code }} / {{ $student->program->name }}</span>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-3 text-sm text-slate-600">
                        <span class="metric-pill font-data">{{ $student->email }}</span>
                        @if($student->phone)
                            <span class="metric-pill font-data">{{ $student->phone }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <span class="{{ $statusClass }}">{{ $student->status->name }}</span>
        </div>
    </section>

    <aside class="surface-panel p-6">
        <p class="section-kicker">Snapshot</p>
        <div class="summary-list mt-5">
            <div class="summary-item">
                <div>
                    <p class="text-sm font-semibold text-slate-950">Enrollment date</p>
                    <p class="mt-1 text-sm text-slate-500">First recorded on</p>
                </div>
                <span class="font-data text-sm text-slate-700">{{ \Illuminate\Support\Carbon::parse($student->enrollment_date)->format('M d, Y') }}</span>
            </div>
            <div class="summary-item">
                <div>
                    <p class="text-sm font-semibold text-slate-950">Course count</p>
                    <p class="mt-1 text-sm text-slate-500">Attached to this record</p>
                </div>
                <span class="font-data text-sm text-slate-700">{{ $student->courses->count() }}</span>
            </div>
            <div class="summary-item">
                <div>
                    <p class="text-sm font-semibold text-slate-950">Gender</p>
                    <p class="mt-1 text-sm text-slate-500">Roster field</p>
                </div>
                <span class="text-sm text-slate-700">{{ $student->gender->name }}</span>
            </div>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('students.edit', $student) }}" class="btn btn-primary">Edit record</a>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Back to roster</a>
            <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Delete {{ addslashes($student->full_name) }}? This cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </aside>
</div>

<div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_minmax(320px,0.92fr)]">
    <section class="surface-panel p-6">
        <p class="section-kicker">Personal details</p>
        <div class="mt-6 grid gap-4 sm:grid-cols-2">
            <div class="record-card p-5">
                <p class="data-point-label">Email</p>
                <p class="mt-2 font-data text-sm text-slate-700">{{ $student->email }}</p>
            </div>
            <div class="record-card p-5">
                <p class="data-point-label">Phone</p>
                <p class="mt-2 font-data text-sm text-slate-700">{{ $student->phone ?: 'Not provided' }}</p>
            </div>
            <div class="record-card p-5">
                <p class="data-point-label">Gender</p>
                <p class="mt-2 text-sm font-semibold text-slate-950">{{ $student->gender->name }}</p>
            </div>
            <div class="record-card p-5">
                <p class="data-point-label">Student ID</p>
                <p class="mt-2 font-data text-sm text-slate-700">{{ $student->student_id }}</p>
            </div>
        </div>
    </section>

    <section class="surface-panel p-6">
        <p class="section-kicker">Academic footprint</p>
        <div class="mt-6 grid gap-4 sm:grid-cols-2">
            <div class="record-card p-5">
                <p class="data-point-label">Program</p>
                <p class="mt-2 text-sm font-semibold text-slate-950">{{ $student->program->name }}</p>
                <p class="mt-1 text-sm text-slate-500">{{ $student->program->code }}</p>
            </div>
            <div class="record-card p-5">
                <p class="data-point-label">Status</p>
                <p class="mt-2 text-sm font-semibold text-slate-950">{{ $student->status->name }}</p>
            </div>
            <div class="record-card p-5">
                <p class="data-point-label">Enrollment date</p>
                <p class="mt-2 font-data text-sm text-slate-700">{{ \Illuminate\Support\Carbon::parse($student->enrollment_date)->format('M d, Y') }}</p>
            </div>
            <div class="record-card p-5">
                <p class="data-point-label">Courses attached</p>
                <p class="mt-2 font-data text-sm text-slate-700">{{ $student->courses->count() }}</p>
            </div>
        </div>
    </section>
</div>

<section class="surface-panel p-6">
    <div class="flex flex-col gap-4 border-b border-slate-900/8 pb-6 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="section-kicker">Course load</p>
            <h3 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Courses attached to this student</h3>
            <p class="mt-2 text-sm leading-7 text-slate-600">Each course below is linked through the student record and can be updated from the edit screen.</p>
        </div>
        <span class="page-count-chip">{{ $student->courses->count() }} enrolled</span>
    </div>

    @if($student->courses->isEmpty())
        <div class="empty-state">
            <h4 class="text-xl font-semibold tracking-tight text-slate-950">No courses are attached yet.</h4>
            <p class="max-w-xl text-sm leading-7 text-slate-600">Open the edit form to assign the student to one or more courses once scheduling is confirmed.</p>
            <a href="{{ route('students.edit', $student) }}" class="btn btn-primary">Edit courses</a>
        </div>
    @else
        <div class="catalog-grid p-6">
            @foreach($student->courses as $course)
                <article class="record-card p-5">
                    <span class="code-pill">{{ $course->code }}</span>
                    <h4 class="mt-4 text-lg font-semibold tracking-tight text-slate-950">{{ $course->name }}</h4>
                    @if($course->description)
                        <p class="mt-2 text-sm leading-7 text-slate-600 trimmed-copy">{{ $course->description }}</p>
                    @endif
                    @if($course->pivot->grade)
                        <div class="mt-4">
                            <span class="status-badge status-badge--success">Grade {{ $course->pivot->grade }}</span>
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    @endif
</section>
@endsection
