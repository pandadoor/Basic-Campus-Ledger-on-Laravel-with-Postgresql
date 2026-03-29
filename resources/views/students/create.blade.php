@extends('students.layout')

@section('page-title', 'Add Student')
@section('page-subtitle', 'Create a complete student record with identity, placement, and course context.')

@section('content')
<div class="grid gap-6 xl:grid-cols-[minmax(0,1.2fr)_320px]">
    <section class="surface-panel overflow-hidden">
        <div class="border-b border-slate-900/8 px-6 py-6 sm:px-8">
            <p class="section-kicker">Intake form</p>
            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Add a new student without leaving gaps in the record.</h2>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">Capture the essentials now, then link the student to a program, status, and course load while the information is still fresh.</p>
        </div>

        <form method="POST" action="{{ route('students.store') }}" novalidate>
            @csrf
            @include('students._form')

            <div class="flex flex-wrap gap-3 border-t border-slate-900/8 px-6 py-6 sm:px-8">
                <button type="submit" class="btn btn-primary">Save student</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </section>

    <div class="space-y-6">
        <aside class="surface-panel p-6">
            <p class="section-kicker">Checklist</p>
            <div class="summary-list mt-5">
                <div class="summary-item">
                    <div>
                        <p class="text-sm font-semibold text-slate-950">Programs ready</p>
                        <p class="mt-1 text-sm text-slate-500">Available for assignment right away</p>
                    </div>
                    <span class="font-data text-sm text-slate-700">{{ $programs->count() }}</span>
                </div>
                <div class="summary-item">
                    <div>
                        <p class="text-sm font-semibold text-slate-950">Course options</p>
                        <p class="mt-1 text-sm text-slate-500">Selectable during intake</p>
                    </div>
                    <span class="font-data text-sm text-slate-700">{{ $courses->count() }}</span>
                </div>
                <div class="summary-item">
                    <div>
                        <p class="text-sm font-semibold text-slate-950">Status choices</p>
                        <p class="mt-1 text-sm text-slate-500">Lifecycle states already configured</p>
                    </div>
                    <span class="font-data text-sm text-slate-700">{{ $statuses->count() }}</span>
                </div>
            </div>
        </aside>

        <aside class="surface-panel p-6">
            <p class="section-kicker">Suggested flow</p>
            <div class="mt-4 space-y-4 text-sm leading-7 text-slate-600">
                <p>1. Confirm the roster-facing identity fields first so the student is easy to search later.</p>
                <p>2. Assign the correct program and status before saving to keep dashboard filters accurate.</p>
                <p>3. Add courses now if they are known, or leave them blank and return once scheduling is final.</p>
            </div>
        </aside>
    </div>
</div>
@endsection
