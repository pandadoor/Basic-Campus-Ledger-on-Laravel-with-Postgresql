@extends('students.layout')

@section('page-title', 'Add Course')
@section('page-subtitle', 'Create a new course option for student enrollment and record keeping.')

@section('content')
<div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
    <section class="surface-panel overflow-hidden">
        <div class="border-b border-slate-900/8 px-6 py-6 sm:px-8">
            <p class="section-kicker">Course setup</p>
            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Add a new course to the offering catalog.</h2>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">A clear code and short summary make the course easier to recognize when staff attach it to a student record.</p>
        </div>

        <form method="POST" action="{{ route('courses.store') }}" class="space-y-6 px-6 py-6 sm:px-8">
            @csrf

            <div class="field-group">
                <label for="code" class="field-label">Course code <span class="text-amber-600">*</span></label>
                <input id="code" type="text" name="code" value="{{ old('code') }}" placeholder="CS101" class="text-input font-data {{ $errors->has('code') ? 'field-error' : '' }}">
                @error('code')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="name" class="field-label">Course name <span class="text-amber-600">*</span></label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Introduction to Programming" class="text-input {{ $errors->has('name') ? 'field-error' : '' }}">
                @error('name')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="description" class="field-label">Description</label>
                <textarea id="description" name="description" placeholder="Brief summary of the course scope and focus" class="textarea-input {{ $errors->has('description') ? 'field-error' : '' }}">{{ old('description') }}</textarea>
                @error('description')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Save course</button>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </section>

    <aside class="space-y-6">
        <section class="surface-panel p-6">
            <p class="section-kicker">Course tip</p>
            <p class="mt-4 text-sm leading-7 text-slate-600">Use descriptions for the distinctions that are not obvious from the code alone, especially when multiple subjects sound similar.</p>
        </section>

        <section class="surface-panel p-6">
            <p class="section-kicker">Example format</p>
            <div class="mt-4 space-y-3 text-sm text-slate-600">
                <p><span class="font-data text-slate-900">CS101</span> / Introduction to Programming</p>
                <p><span class="font-data text-slate-900">MATH201</span> / Discrete Structures</p>
                <p><span class="font-data text-slate-900">ENG105</span> / Academic Writing</p>
            </div>
        </section>
    </aside>
</div>
@endsection
