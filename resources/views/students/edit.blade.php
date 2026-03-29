@extends('students.layout')

@section('page-title', 'Edit Student')
@section('page-subtitle', 'Update the record for ' . $student->full_name . ' without losing context.')

@section('content')
<div class="grid gap-6 xl:grid-cols-[minmax(0,1.2fr)_320px]">
    <section class="surface-panel overflow-hidden">
        <div class="border-b border-slate-900/8 px-6 py-6 sm:px-8">
            <p class="section-kicker">Record maintenance</p>
            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Refine the record while keeping the student context in view.</h2>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">Use this form to correct identity details, move the student into a new status, or adjust the current course load.</p>
        </div>

        <form method="POST" action="{{ route('students.update', $student) }}" novalidate>
            @csrf
            @method('PUT')
            @include('students._form')

            <div class="flex flex-wrap gap-3 border-t border-slate-900/8 px-6 py-6 sm:px-8">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('students.show', $student) }}" class="btn btn-secondary">View profile</a>
                <a href="{{ route('students.index') }}" class="btn btn-ghost">Back to roster</a>
            </div>
        </form>
    </section>

    <div class="space-y-6">
        <aside class="surface-panel p-6">
            <p class="section-kicker">Record snapshot</p>
            <div class="summary-list mt-5">
                <div class="summary-item">
                    <div>
                        <p class="text-sm font-semibold text-slate-950">Student ID</p>
                        <p class="mt-1 text-sm text-slate-500">Current roster identifier</p>
                    </div>
                    <span class="font-data text-sm text-slate-700">{{ $student->student_id }}</span>
                </div>
                <div class="summary-item">
                    <div>
                        <p class="text-sm font-semibold text-slate-950">Program</p>
                        <p class="mt-1 text-sm text-slate-500">Current academic placement</p>
                    </div>
                    <span class="text-sm text-slate-700">{{ $student->program->code }}</span>
                </div>
                <div class="summary-item">
                    <div>
                        <p class="text-sm font-semibold text-slate-950">Status</p>
                        <p class="mt-1 text-sm text-slate-500">Lifecycle state on record</p>
                    </div>
                    <span class="text-sm text-slate-700">{{ $student->status->name }}</span>
                </div>
                <div class="summary-item">
                    <div>
                        <p class="text-sm font-semibold text-slate-950">Courses</p>
                        <p class="mt-1 text-sm text-slate-500">Attached right now</p>
                    </div>
                    <span class="font-data text-sm text-slate-700">{{ $student->courses->count() }}</span>
                </div>
            </div>
        </aside>

        <aside class="surface-panel p-6">
            <p class="section-kicker">Editing tip</p>
            <p class="mt-4 text-sm leading-7 text-slate-600">When changing status or program, take a quick look at the attached courses too so the record stays internally consistent.</p>
        </aside>
    </div>
</div>
@endsection
