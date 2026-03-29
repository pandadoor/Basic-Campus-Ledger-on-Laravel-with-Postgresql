@extends('students.layout')

@section('page-title', 'Admin Dashboard')
@section('page-subtitle', 'Manage the student roster, programs, and course catalog from one responsive workspace.')

@section('content')
<div class="grid gap-6 xl:grid-cols-[minmax(0,1.35fr)_320px]">
    <section class="surface-panel p-6 sm:p-8">
        <p class="section-kicker">Admin hub</p>
        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">Modern school admin, without the clutter.</h2>
        <p class="mt-3 max-w-3xl text-base leading-7 text-slate-600">Use this dashboard to jump into the roster, add new reference data, and keep an eye on the records that shape the rest of the app.</p>

        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('students.create') }}" class="btn btn-primary">Add student</a>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Open roster</a>
            <a href="{{ route('programs.index') }}" class="btn btn-ghost">Manage programs</a>
            <a href="{{ route('courses.index') }}" class="btn btn-ghost">Manage courses</a>
        </div>
    </section>

    <section class="surface-panel p-6">
        <p class="section-kicker">Status overview</p>
        <div class="summary-list mt-5">
            @foreach($statusBreakdown as $status)
                <div class="summary-item">
                    <div>
                        <p class="text-base font-semibold text-slate-950">{{ $status->name }}</p>
                        <p class="mt-1 text-base text-slate-500">Students currently in this state</p>
                    </div>
                    <span class="font-data text-base text-slate-700">{{ $status->students_count }}</span>
                </div>
            @endforeach
        </div>
    </section>
</div>

<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    @foreach([
        ['label' => 'Students', 'value' => $stats['students'], 'copy' => 'Records currently in the roster', 'accent' => 'rgba(37, 99, 235, 0.18)'],
        ['label' => 'Active', 'value' => $stats['active'], 'copy' => 'Students in active standing', 'accent' => 'rgba(15, 118, 110, 0.18)'],
        ['label' => 'Programs', 'value' => $stats['programs'], 'copy' => 'Academic tracks available', 'accent' => 'rgba(99, 102, 241, 0.18)'],
        ['label' => 'Courses', 'value' => $stats['courses'], 'copy' => 'Course offerings ready to assign', 'accent' => 'rgba(217, 119, 6, 0.18)'],
    ] as $card)
        <article class="stat-card" style="--card-accent: {{ $card['accent'] }}">
            <p class="stat-kicker">{{ $card['label'] }}</p>
            <p class="stat-value font-data">{{ $card['value'] }}</p>
            <p class="stat-copy">{{ $card['copy'] }}</p>
        </article>
    @endforeach
</div>

<div class="grid gap-6 xl:grid-cols-2">
    <section class="surface-panel overflow-hidden">
        <div class="border-b border-slate-900/8 px-6 py-5">
            <p class="section-kicker">Quick add</p>
            <h3 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Create a new program</h3>
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
                <button type="submit" class="btn btn-primary">Save program</button>
                <a href="{{ route('programs.index') }}" class="btn btn-secondary">View all</a>
            </div>
        </form>
    </section>

    <section class="surface-panel overflow-hidden">
        <div class="border-b border-slate-900/8 px-6 py-5">
            <p class="section-kicker">Quick add</p>
            <h3 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Create a new course</h3>
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
                    placeholder="Short summary that helps staff identify the right course"
                    class="textarea-input {{ $errors->dashboardCourse->has('description') ? 'field-error' : '' }}"
                >{{ $errors->dashboardCourse->any() ? old('description') : '' }}</textarea>
                @if($errors->dashboardCourse->has('description'))
                    <p class="error-text">{{ $errors->dashboardCourse->first('description') }}</p>
                @endif
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="btn btn-primary">Save course</button>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">View all</a>
            </div>
        </form>
    </section>
</div>

<div class="grid gap-6 xl:grid-cols-[minmax(0,1.2fr)_minmax(0,0.8fr)]">
    <section class="surface-panel overflow-hidden">
        <div class="flex items-center justify-between gap-4 border-b border-slate-900/8 px-6 py-5">
            <div>
                <p class="section-kicker">Recent students</p>
                <h3 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Latest roster updates</h3>
            </div>
            <a href="{{ route('students.index') }}" class="btn btn-ghost">Full roster</a>
        </div>

        <div class="space-y-4 p-4">
            @forelse($recentStudents as $student)
                <article class="record-card p-5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <span class="code-pill">{{ $student->student_id }}</span>
                            <h4 class="mt-3 text-lg font-semibold tracking-tight text-slate-950">{{ $student->full_name }}</h4>
                            <p class="mt-1 text-base text-slate-500">{{ $student->program->code }} / {{ $student->program->name }}</p>
                        </div>
                        <span class="page-count-chip">{{ $student->status->name }}</span>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-3 text-base text-slate-500">
                        <span class="font-data">{{ $student->email }}</span>
                        <span class="font-data">{{ \Illuminate\Support\Carbon::parse($student->enrollment_date)->format('M d, Y') }}</span>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <p class="text-base text-slate-600">No students yet. Start by adding the first record.</p>
                    <a href="{{ route('students.create') }}" class="btn btn-primary">Add student</a>
                </div>
            @endforelse
        </div>
    </section>

    <div class="space-y-6">
        <section class="surface-panel overflow-hidden">
            <div class="flex items-center justify-between gap-4 border-b border-slate-900/8 px-6 py-5">
                <div>
                    <p class="section-kicker">Programs</p>
                    <h3 class="mt-2 text-xl font-semibold tracking-tight text-slate-950">Catalog snapshot</h3>
                </div>
                <a href="{{ route('programs.index') }}" class="btn btn-ghost">Open</a>
            </div>
            <div class="p-6">
                <div class="summary-list">
                    @forelse($programs as $program)
                        <div class="summary-item">
                            <div>
                                <p class="font-semibold text-slate-950">{{ $program->code }}</p>
                                <p class="mt-1 text-base text-slate-500">{{ $program->name }}</p>
                            </div>
                            <span class="font-data text-base text-slate-700">{{ $program->students_count }}</span>
                        </div>
                    @empty
                        <p class="text-base text-slate-600">No programs yet.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="surface-panel overflow-hidden">
            <div class="flex items-center justify-between gap-4 border-b border-slate-900/8 px-6 py-5">
                <div>
                    <p class="section-kicker">Courses</p>
                    <h3 class="mt-2 text-xl font-semibold tracking-tight text-slate-950">Offering snapshot</h3>
                </div>
                <a href="{{ route('courses.index') }}" class="btn btn-ghost">Open</a>
            </div>
            <div class="p-6">
                <div class="summary-list">
                    @forelse($courses as $course)
                        <div class="summary-item">
                            <div>
                                <p class="font-semibold text-slate-950">{{ $course->code }}</p>
                                <p class="mt-1 text-base text-slate-500">{{ $course->name }}</p>
                            </div>
                            <span class="font-data text-base text-slate-700">{{ $course->students_count }}</span>
                        </div>
                    @empty
                        <p class="text-base text-slate-600">No courses yet.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
