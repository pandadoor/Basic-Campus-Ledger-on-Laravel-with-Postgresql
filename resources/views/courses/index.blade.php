@extends('students.layout')

@section('page-title', 'Courses')
@section('page-subtitle', 'Maintain the course offering that powers student enrollment selection.')

@section('content')
@php
    $busiestCourse = $courses->sortByDesc('students_count')->first();
    $totalEnrollments = $courses->sum('students_count');
@endphp

<div class="grid gap-6 xl:grid-cols-[minmax(0,1.35fr)_340px]">
    <section class="surface-panel hero-panel">
        <p class="section-kicker">Course catalog</p>
        <h2 class="section-title mt-4">Keep every offering clear before it lands in student records.</h2>
        <p class="section-copy mt-4">The updated course view favors readable codes, quick edits, and lightweight descriptions so enrollment choices stay understandable across the whole app.</p>

        <div class="mt-6 flex flex-wrap gap-3">
            <span class="metric-pill">{{ $courses->count() }} courses listed</span>
            <span class="metric-pill">{{ $totalEnrollments }} student enrollments attached</span>
            @if($busiestCourse)
                <span class="metric-pill">{{ $busiestCourse->code }} is the busiest course</span>
            @endif
        </div>
    </section>

    <section class="surface-panel p-6">
        <p class="section-kicker">Snapshot</p>
        <div class="summary-list mt-5">
            <div class="summary-item">
                <div>
                    <p class="text-sm font-semibold text-slate-950">Course count</p>
                    <p class="mt-1 text-sm text-slate-500">Visible in the catalog right now</p>
                </div>
                <span class="font-data text-sm text-slate-700">{{ $courses->count() }}</span>
            </div>
            <div class="summary-item">
                <div>
                    <p class="text-sm font-semibold text-slate-950">Busiest course</p>
                    <p class="mt-1 text-sm text-slate-500">Highest linked student count</p>
                </div>
                <span class="text-sm text-slate-700">{{ $busiestCourse?->code ?? 'None yet' }}</span>
            </div>
            <div class="summary-item">
                <div>
                    <p class="text-sm font-semibold text-slate-950">Enrollment load</p>
                    <p class="mt-1 text-sm text-slate-500">Across all listed courses</p>
                </div>
                <span class="font-data text-sm text-slate-700">{{ $totalEnrollments }}</span>
            </div>
        </div>
    </section>
</div>

@if($courses->isEmpty())
    <section class="surface-panel empty-state">
        <p class="section-kicker">Nothing here yet</p>
        <h3 class="text-2xl font-semibold tracking-tight text-slate-950">No courses have been created.</h3>
        <p class="max-w-xl text-sm leading-7 text-slate-600">Add a course so students can start building out complete enrollment records.</p>
        <a href="{{ route('courses.create') }}" class="btn btn-primary">Add course</a>
    </section>
@else
    <section class="catalog-grid">
        @foreach($courses as $course)
            <article class="record-card flex h-full flex-col p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <span class="code-pill">{{ $course->code }}</span>
                        <h3 class="mt-4 text-xl font-semibold tracking-tight text-slate-950">{{ $course->name }}</h3>
                    </div>
                    <span class="page-count-chip">{{ $course->students_count }} enrolled</span>
                </div>

                <p class="mt-5 flex-1 text-sm leading-7 text-slate-600 {{ $course->description ? 'trimmed-copy' : '' }}">
                    {{ $course->description ?: 'No description added yet. A short course summary helps staff and students recognize the right offering faster.' }}
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('courses.edit', $course) }}" class="btn btn-secondary">Edit</a>
                    <form method="POST" action="{{ route('courses.destroy', $course) }}" onsubmit="return confirm('Delete {{ addslashes($course->name) }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </article>
        @endforeach
    </section>
@endif
@endsection
