@extends('students.layout')

@section('page-title', 'Edit Program')
@section('page-subtitle', 'Adjust program details while keeping existing student assignments stable.')

@section('content')
<div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
    <section class="surface-panel overflow-hidden">
        <div class="border-b border-slate-900/8 px-6 py-6 sm:px-8">
            <p class="section-kicker">Catalog maintenance</p>
            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Update the program details with care.</h2>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">Small wording changes can improve clarity, but stable codes and names help existing student records stay easy to interpret.</p>
        </div>

        <form method="POST" action="{{ route('programs.update', $program) }}" class="space-y-6 px-6 py-6 sm:px-8">
            @csrf
            @method('PUT')

            <div class="field-group">
                <label for="code" class="field-label">Program code <span class="text-amber-600">*</span></label>
                <input id="code" type="text" name="code" value="{{ old('code', $program->code) }}" placeholder="BSCS" class="text-input font-data {{ $errors->has('code') ? 'field-error' : '' }}">
                @error('code')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="name" class="field-label">Program name <span class="text-amber-600">*</span></label>
                <input id="name" type="text" name="name" value="{{ old('name', $program->name) }}" placeholder="BS Computer Science" class="text-input {{ $errors->has('name') ? 'field-error' : '' }}">
                @error('name')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="department" class="field-label">Department</label>
                <input id="department" type="text" name="department" value="{{ old('department', $program->department) }}" placeholder="College of Computing" class="text-input {{ $errors->has('department') ? 'field-error' : '' }}">
                @error('department')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('programs.index') }}" class="btn btn-secondary">Back to programs</a>
            </div>
        </form>
    </section>

    <aside class="space-y-6">
        <section class="surface-panel p-6">
            <p class="section-kicker">Current record</p>
            <div class="summary-list mt-5">
                <div class="summary-item">
                    <div>
                        <p class="text-sm font-semibold text-slate-950">Code</p>
                        <p class="mt-1 text-sm text-slate-500">Roster-facing identifier</p>
                    </div>
                    <span class="font-data text-sm text-slate-700">{{ $program->code }}</span>
                </div>
                <div class="summary-item">
                    <div>
                        <p class="text-sm font-semibold text-slate-950">Students linked</p>
                        <p class="mt-1 text-sm text-slate-500">Protected by delete guard when in use</p>
                    </div>
                    <span class="font-data text-sm text-slate-700">{{ $program->students()->count() }}</span>
                </div>
            </div>
        </section>

        <section class="surface-panel p-6">
            <p class="section-kicker">Editing tip</p>
            <p class="mt-4 text-sm leading-7 text-slate-600">If many students already belong to this program, prefer clarity improvements over major renames so historical records remain easy to read.</p>
        </section>
    </aside>
</div>
@endsection
