@extends('students.layout')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview and quick create tools.')

@section('content')
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    @foreach([
        ['label' => 'Students', 'value' => $stats['students'], 'accent' => 'rgba(37, 99, 235, 0.4)'],
        ['label' => 'Active', 'value' => $stats['active'], 'accent' => 'rgba(15, 118, 110, 0.4)'],
        ['label' => 'Programs', 'value' => $stats['programs'], 'accent' => 'rgba(99, 102, 241, 0.4)'],
        ['label' => 'Courses', 'value' => $stats['courses'], 'accent' => 'rgba(249, 115, 22, 0.4)'],
    ] as $card)
        <article class="stat-card" style="--card-accent: {{ $card['accent'] }};">
            <p class="stat-kicker">{{ $card['label'] }}</p>
            <p class="stat-value font-data">{{ $card['value'] }}</p>
        </article>
    @endforeach
</div>

<section class="surface-panel p-5">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="section-kicker">Status</p>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Current roster state</h2>
        </div>

        <div class="flex flex-wrap gap-2">
            @foreach($statusBreakdown as $status)
                <span class="metric-pill">{{ $status->name }}: {{ $status->students_count }}</span>
            @endforeach
        </div>
    </div>
</section>

<div class="grid gap-6 xl:grid-cols-2">
    <section class="surface-panel overflow-hidden">
        <div class="border-b border-slate-900/8 px-6 py-5">
            <p class="section-kicker">Quick add</p>
            <h3 class="mt-2 text-xl font-semibold tracking-tight text-slate-950">Program</h3>
        </div>

        <form method="POST" action="{{ route('programs.store') }}" class="space-y-5 px-6 py-6">
            @csrf
            <input type="hidden" name="redirect_route" value="admin.index">
            <input type="hidden" name="error_bag" value="dashboardProgram">

            <div class="field-group">
                <label for="dashboard_program_code" class="field-label">Program code <span class="text-amber-600">*</span></label>
                <input
                    id="dashboard_program_code"
                    type="text"
                    name="code"
                    value="{{ $errors->dashboardProgram->any() ? old('code') : '' }}"
                    placeholder="BSCS"
                    class="text-input font-data {{ $errors->dashboardProgram->has('code') ? 'field-error' : '' }}"
                >
                @if($errors->dashboardProgram->has('code'))
                    <p class="error-text">{{ $errors->dashboardProgram->first('code') }}</p>
                @endif
            </div>

            <div class="field-group">
                <label for="dashboard_program_name" class="field-label">Program name <span class="text-amber-600">*</span></label>
                <input
                    id="dashboard_program_name"
                    type="text"
                    name="name"
                    value="{{ $errors->dashboardProgram->any() ? old('name') : '' }}"
                    placeholder="BS Computer Science"
                    class="text-input {{ $errors->dashboardProgram->has('name') ? 'field-error' : '' }}"
                >
                @if($errors->dashboardProgram->has('name'))
                    <p class="error-text">{{ $errors->dashboardProgram->first('name') }}</p>
                @endif
            </div>

            <div class="field-group">
                <label for="dashboard_program_department" class="field-label">Department</label>
                <input
                    id="dashboard_program_department"
                    type="text"
                    name="department"
                    value="{{ $errors->dashboardProgram->any() ? old('department') : '' }}"
                    placeholder="College of Computing"
                    class="text-input {{ $errors->dashboardProgram->has('department') ? 'field-error' : '' }}"
                >
                @if($errors->dashboardProgram->has('department'))
                    <p class="error-text">{{ $errors->dashboardProgram->first('department') }}</p>
                @endif
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('programs.index') }}" class="btn btn-secondary">View all</a>
            </div>
        </form>
    </section>

    <section class="surface-panel overflow-hidden">
        <div class="border-b border-slate-900/8 px-6 py-5">
            <p class="section-kicker">Quick add</p>
            <h3 class="mt-2 text-xl font-semibold tracking-tight text-slate-950">Course</h3>
        </div>

        <form method="POST" action="{{ route('courses.store') }}" class="space-y-5 px-6 py-6">
            @csrf
            <input type="hidden" name="redirect_route" value="admin.index">
            <input type="hidden" name="error_bag" value="dashboardCourse">

            <div class="field-group">
                <label for="dashboard_course_code" class="field-label">Course code <span class="text-amber-600">*</span></label>
                <input
                    id="dashboard_course_code"
                    type="text"
                    name="code"
                    value="{{ $errors->dashboardCourse->any() ? old('code') : '' }}"
                    placeholder="CS101"
                    class="text-input font-data {{ $errors->dashboardCourse->has('code') ? 'field-error' : '' }}"
                >
                @if($errors->dashboardCourse->has('code'))
                    <p class="error-text">{{ $errors->dashboardCourse->first('code') }}</p>
                @endif
            </div>

            <div class="field-group">
                <label for="dashboard_course_name" class="field-label">Course name <span class="text-amber-600">*</span></label>
                <input
                    id="dashboard_course_name"
                    type="text"
                    name="name"
                    value="{{ $errors->dashboardCourse->any() ? old('name') : '' }}"
                    placeholder="Introduction to Programming"
                    class="text-input {{ $errors->dashboardCourse->has('name') ? 'field-error' : '' }}"
                >
                @if($errors->dashboardCourse->has('name'))
                    <p class="error-text">{{ $errors->dashboardCourse->first('name') }}</p>
                @endif
            </div>

            <div class="field-group">
                <label for="dashboard_course_description" class="field-label">Description</label>
                <textarea
                    id="dashboard_course_description"
                    name="description"
                    placeholder="Short summary"
                    class="textarea-input {{ $errors->dashboardCourse->has('description') ? 'field-error' : '' }}"
                >{{ $errors->dashboardCourse->any() ? old('description') : '' }}</textarea>
                @if($errors->dashboardCourse->has('description'))
                    <p class="error-text">{{ $errors->dashboardCourse->first('description') }}</p>
                @endif
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">View all</a>
            </div>
        </form>
    </section>
</div>

<div class="grid gap-6 xl:grid-cols-[minmax(0,1.15fr)_320px] xl:items-start">
    <section class="surface-panel overflow-hidden">
        <div class="flex items-center justify-between gap-4 border-b border-slate-900/8 px-6 py-5">
            <div>
                <p class="section-kicker">Recent students</p>
                <h3 class="mt-2 text-xl font-semibold tracking-tight text-slate-950">Latest changes</h3>
            </div>
            <a href="{{ route('students.index') }}" class="btn btn-ghost">Roster</a>
        </div>

        <div class="space-y-4 p-4">
            @forelse($recentStudents as $student)
                <article class="record-card p-5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <span class="code-pill">{{ $student->student_id }}</span>
                            <h4 class="mt-3 text-lg font-semibold tracking-tight text-slate-950">{{ $student->full_name }}</h4>
                            <p class="mt-1 text-sm text-slate-500">{{ $student->program->code }}</p>
                        </div>
                        <span class="page-count-chip">{{ $student->status->name }}</span>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-3 text-sm text-slate-500">
                        <span class="font-data">{{ $student->email }}</span>
                        <span class="font-data">{{ \Illuminate\Support\Carbon::parse($student->enrollment_date)->format('M d, Y') }}</span>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <p class="text-sm text-slate-600">No students yet.</p>
                    <a href="{{ route('students.create') }}" class="btn btn-primary">Add student</a>
                </div>
            @endforelse
        </div>
    </section>

    <div class="space-y-6">
        <section class="surface-panel overflow-hidden">
            <div class="flex items-center justify-between gap-4 border-b border-slate-900/8 px-6 py-5">
                <p class="section-kicker">Programs</p>
                <a href="{{ route('programs.index') }}" class="btn btn-ghost">Open</a>
            </div>
            <div class="p-6">
                <div class="summary-list">
                    @forelse($programs as $program)
                        <div class="summary-item">
                            <div>
                                <p class="font-semibold text-slate-950">{{ $program->code }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $program->name }}</p>
                            </div>
                            <span class="font-data text-base text-slate-700">{{ $program->students_count }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-slate-600">No programs yet.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="surface-panel overflow-hidden">
            <div class="flex items-center justify-between gap-4 border-b border-slate-900/8 px-6 py-5">
                <p class="section-kicker">Courses</p>
                <a href="{{ route('courses.index') }}" class="btn btn-ghost">Open</a>
            </div>
            <div class="p-6">
                <div class="summary-list">
                    @forelse($courses as $course)
                        <div class="summary-item">
                            <div>
                                <p class="font-semibold text-slate-950">{{ $course->code }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $course->name }}</p>
                            </div>
                            <span class="font-data text-base text-slate-700">{{ $course->students_count }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-slate-600">No courses yet.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
