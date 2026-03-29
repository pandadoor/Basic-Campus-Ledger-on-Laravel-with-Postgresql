@extends('students.layout')

@section('page-title', 'Add Program')
@section('page-subtitle', 'Create a new academic track for student assignment and reporting.')

@section('content')
<div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
    <section class="surface-panel overflow-hidden">
        <div class="border-b border-slate-900/8 px-6 py-6 sm:px-8">
            <p class="section-kicker">Program setup</p>
            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Add a new academic track to the catalog.</h2>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">Strong codes and plain-language names make filters easier to use and keep student records consistent as the catalog grows.</p>
        </div>

        <form method="POST" action="{{ route('programs.store') }}" class="space-y-6 px-6 py-6 sm:px-8">
            @csrf

            <div class="field-group">
                <label for="code" class="field-label">Program code <span class="text-amber-600">*</span></label>
                <input id="code" type="text" name="code" value="{{ old('code') }}" placeholder="BSCS" class="text-input font-data {{ $errors->has('code') ? 'field-error' : '' }}">
                @error('code')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="name" class="field-label">Program name <span class="text-amber-600">*</span></label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="BS Computer Science" class="text-input {{ $errors->has('name') ? 'field-error' : '' }}">
                @error('name')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="department" class="field-label">Department</label>
                <input id="department" type="text" name="department" value="{{ old('department') }}" placeholder="College of Computing" class="text-input {{ $errors->has('department') ? 'field-error' : '' }}">
                @error('department')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Save program</button>
                <a href="{{ route('programs.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </section>

    <aside class="space-y-6">
        <section class="surface-panel p-6">
            <p class="section-kicker">Naming tip</p>
            <p class="mt-4 text-sm leading-7 text-slate-600">Use a short code that students and staff already recognize, then keep the full name specific enough to avoid overlap with similar programs.</p>
        </section>

        <section class="surface-panel p-6">
            <p class="section-kicker">Examples</p>
            <div class="mt-4 space-y-3 text-sm text-slate-600">
                <p><span class="font-data text-slate-900">BSCS</span> / BS Computer Science</p>
                <p><span class="font-data text-slate-900">BSIT</span> / BS Information Technology</p>
                <p><span class="font-data text-slate-900">BSA</span> / BS Accountancy</p>
            </div>
        </section>
    </aside>
</div>
@endsection
