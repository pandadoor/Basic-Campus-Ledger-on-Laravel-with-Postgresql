@extends('students.layout')

@section('page-title', 'Programs')
@section('page-subtitle', 'Manage the academic catalog students are assigned into.')

@section('content')
@php
    $largestProgram = $programs->sortByDesc('students_count')->first();
    $totalStudents = $programs->sum('students_count');
@endphp

<div class="grid gap-6 xl:grid-cols-[minmax(0,1.35fr)_340px]">
    <section class="surface-panel hero-panel">
        <p class="section-kicker">Program catalog</p>
        <h2 class="section-title mt-4">Keep the academic structure clean and easy to scan.</h2>
        <p class="section-copy mt-4">Programs power student assignment, filtering, and reporting, so the refreshed catalog favors clear codes, quick edits, and instant visibility into enrollment volume.</p>

        <div class="mt-6 flex flex-wrap gap-3">
            <span class="metric-pill">{{ $programs->count() }} active programs</span>
            <span class="metric-pill">{{ $totalStudents }} total student assignments</span>
            @if($largestProgram)
                <span class="metric-pill">{{ $largestProgram->code }} is the largest roster</span>
            @endif
        </div>
    </section>

    <section class="surface-panel p-6">
        <p class="section-kicker">Snapshot</p>
        <div class="summary-list mt-5">
            <div class="summary-item">
                <div>
                    <p class="text-sm font-semibold text-slate-950">Programs tracked</p>
                    <p class="mt-1 text-sm text-slate-500">Available for new student records</p>
                </div>
                <span class="font-data text-sm text-slate-700">{{ $programs->count() }}</span>
            </div>
            <div class="summary-item">
                <div>
                    <p class="text-sm font-semibold text-slate-950">Largest roster</p>
                    <p class="mt-1 text-sm text-slate-500">Current highest student count</p>
                </div>
                <span class="text-sm text-slate-700">{{ $largestProgram?->code ?? 'None yet' }}</span>
            </div>
            <div class="summary-item">
                <div>
                    <p class="text-sm font-semibold text-slate-950">Assigned students</p>
                    <p class="mt-1 text-sm text-slate-500">Across every listed program</p>
                </div>
                <span class="font-data text-sm text-slate-700">{{ $totalStudents }}</span>
            </div>
        </div>
    </section>
</div>

@if($programs->isEmpty())
    <section class="surface-panel empty-state">
        <p class="section-kicker">Nothing here yet</p>
        <h3 class="text-2xl font-semibold tracking-tight text-slate-950">No programs have been created.</h3>
        <p class="max-w-xl text-sm leading-7 text-slate-600">Add your first program so student records can be assigned to a proper academic track.</p>
        <a href="{{ route('programs.create') }}" class="btn btn-primary">Add program</a>
    </section>
@else
    <section class="catalog-grid">
        @foreach($programs as $program)
            <article class="record-card flex h-full flex-col p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <span class="code-pill">{{ $program->code }}</span>
                        <h3 class="mt-4 text-xl font-semibold tracking-tight text-slate-950">{{ $program->name }}</h3>
                        <p class="mt-2 text-sm leading-7 text-slate-500">{{ $program->department ?: 'Department not set yet' }}</p>
                    </div>
                    <span class="page-count-chip">{{ $program->students_count }} students</span>
                </div>

                <div class="mt-6 rounded-[1.25rem] border border-slate-900/8 bg-white/55 p-4 text-sm leading-7 text-slate-600">
                    {{ $program->students_count > 0 ? 'This program is already linked to student records, so edits should stay stable and easy to recognize.' : 'This program is ready to be used for new student assignments.' }}
                </div>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('programs.edit', $program) }}" class="btn btn-secondary">Edit</a>
                    <form method="POST" action="{{ route('programs.destroy', $program) }}" onsubmit="return confirm('Delete {{ addslashes($program->name) }}?')">
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
