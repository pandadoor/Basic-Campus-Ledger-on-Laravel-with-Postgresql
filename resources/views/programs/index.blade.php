@extends('students.layout')

@section('page-title', 'Programs')
@section('page-subtitle', 'Catalog')

@section('content')
@php
    $largestProgram = $programs->sortByDesc('students_count')->first();
    $totalStudents = $programs->sum('students_count');
@endphp

<section class="surface-panel p-5">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="section-kicker">Catalog</p>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Programs</h2>
        </div>

        <div class="flex flex-wrap gap-2">
            <span class="metric-pill">{{ $programs->count() }} total</span>
            <span class="metric-pill">{{ $totalStudents }} assigned</span>
            @if($largestProgram)
                <span class="metric-pill">{{ $largestProgram->code }} largest</span>
            @endif
        </div>
    </div>
</section>

@if($programs->isEmpty())
    <section class="surface-panel empty-state">
        <p class="section-kicker">Empty</p>
        <h3 class="text-2xl font-semibold tracking-tight text-slate-950">No programs yet.</h3>
        <a href="{{ route('programs.create') }}" class="btn btn-primary">Add program</a>
    </section>
@else
    <section class="catalog-grid">
        @foreach($programs as $program)
            <article class="record-card flex h-full flex-col p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <span class="code-pill">{{ $program->code }}</span>
                        <h3 class="mt-4 text-xl font-semibold tracking-tight text-slate-950">{{ $program->name }}</h3>
                        <p class="mt-2 text-sm text-slate-500">{{ $program->department ?: 'No department' }}</p>
                    </div>
                    <span class="page-count-chip">{{ $program->students_count }}</span>
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
