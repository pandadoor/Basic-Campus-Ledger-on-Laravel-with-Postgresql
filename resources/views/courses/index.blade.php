@extends('students.layout')

@section('page-title', 'Courses')
@section('page-subtitle', 'Catalog')

@section('content')
@php
    $busiestCourse = $courses->sortByDesc('students_count')->first();
    $totalEnrollments = $courses->sum('students_count');
@endphp

<section class="surface-panel p-5">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="section-kicker">Catalog</p>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Courses</h2>
        </div>

        <div class="flex flex-wrap gap-2">
            <span class="metric-pill">{{ $courses->count() }} total</span>
            <span class="metric-pill">{{ $totalEnrollments }} enrollments</span>
            @if($busiestCourse)
                <span class="metric-pill">{{ $busiestCourse->code }} busiest</span>
            @endif
        </div>
    </div>
</section>

@if($courses->isEmpty())
    <section class="surface-panel empty-state">
        <p class="section-kicker">Empty</p>
        <h3 class="text-2xl font-semibold tracking-tight text-slate-950">No courses yet.</h3>
        <a href="{{ route('courses.create') }}" class="btn btn-primary">Add course</a>
    </section>
@else
    <section class="catalog-grid">
        @foreach($courses as $course)
            <article class="record-card flex h-full flex-col p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <span class="code-pill">{{ $course->code }}</span>
                        <h3 class="mt-4 text-xl font-semibold tracking-tight text-slate-950">{{ $course->name }}</h3>
                    </div>
                    <span class="page-count-chip">{{ $course->students_count }}</span>
                </div>

                <p class="mt-4 flex-1 text-sm leading-7 text-slate-600 {{ $course->description ? 'trimmed-copy' : '' }}">
                    {{ $course->description ?: 'No description' }}
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
