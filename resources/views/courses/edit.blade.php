@extends('students.layout')

@section('page-title', 'Edit Course')
@section('page-subtitle', 'Update course details while preserving clarity across student records.')

@section('content')
<div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
    <section class="surface-panel overflow-hidden">
        <div class="border-b border-slate-900/8 px-6 py-6 sm:px-8">
            <p class="section-kicker">Catalog maintenance</p>
            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Refine the course details with a clean audit trail in mind.</h2>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">Because courses appear inside student records, concise naming and readable descriptions make the entire system easier to trust.</p>
        </div>

        <form method="POST" action="{{ route('courses.update', $course) }}" class="space-y-6 px-6 py-6 sm:px-8">
            @csrf
            @method('PUT')

            <div class="field-group">
                <label for="code" class="field-label">Course code <span class="text-amber-600">*</span></label>
                <input id="code" type="text" name="code" value="{{ old('code', $course->code) }}" placeholder="CS101" class="text-input font-data {{ $errors->has('code') ? 'field-error' : '' }}">
                @error('code')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="name" class="field-label">Course name <span class="text-amber-600">*</span></label>
                <input id="name" type="text" name="name" value="{{ old('name', $course->name) }}" placeholder="Introduction to Programming" class="text-input {{ $errors->has('name') ? 'field-error' : '' }}">
                @error('name')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="description" class="field-label">Description</label>
                <textarea id="description" name="description" placeholder="Brief summary of the course scope and focus" class="textarea-input {{ $errors->has('description') ? 'field-error' : '' }}">{{ old('description', $course->description) }}</textarea>
                @error('description')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">Back to courses</a>
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
                        <p class="mt-1 text-sm text-slate-500">Current offering identifier</p>
                    </div>
                    <span class="font-data text-sm text-slate-700">{{ $course->code }}</span>
                </div>
                <div class="summary-item">
                    <div>
                        <p class="text-sm font-semibold text-slate-950">Students linked</p>
                        <p class="mt-1 text-sm text-slate-500">Protected by delete guard when in use</p>
                    </div>
                    <span class="font-data text-sm text-slate-700">{{ $course->students()->count() }}</span>
                </div>
            </div>
        </section>

        <section class="surface-panel p-6">
            <p class="section-kicker">Editing tip</p>
            <p class="mt-4 text-sm leading-7 text-slate-600">Descriptions work best when they explain the scope of the course, not every topic inside it. Keep them short enough to scan inside student profiles.</p>
        </section>
    </aside>
</div>
@endsection
