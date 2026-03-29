@php
    $s = $student ?? null;
    $selectedCourses = old('course_ids', $s ? $s->courses->pluck('id')->toArray() : []);
@endphp

<section class="form-section">
    <div class="mb-6">
        <p class="section-kicker">Identity</p>
        <h3 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Core student profile</h3>
        <p class="mt-2 max-w-2xl text-sm leading-7 text-slate-600">Start with the information that anchors the student in the roster and makes the record searchable later.</p>
    </div>

    <div class="form-section-grid">
        <div class="field-group">
            <label for="student_id" class="field-label">Student ID <span class="text-amber-600">*</span></label>
            <input
                id="student_id"
                type="text"
                name="student_id"
                value="{{ old('student_id', $s->student_id ?? '') }}"
                placeholder="STU-2026-001"
                class="text-input font-data {{ $errors->has('student_id') ? 'field-error' : '' }}"
            >
            @error('student_id')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <div class="field-group">
            <label for="gender_id" class="field-label">Gender <span class="text-amber-600">*</span></label>
            <select id="gender_id" name="gender_id" class="select-input {{ $errors->has('gender_id') ? 'field-error' : '' }}">
                <option value="">Select gender</option>
                @foreach($genders as $gender)
                    <option value="{{ $gender->id }}" {{ (string) old('gender_id', $s->gender_id ?? '') === (string) $gender->id ? 'selected' : '' }}>{{ $gender->name }}</option>
                @endforeach
            </select>
            @error('gender_id')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <div class="field-group">
            <label for="first_name" class="field-label">First name <span class="text-amber-600">*</span></label>
            <input
                id="first_name"
                type="text"
                name="first_name"
                value="{{ old('first_name', $s->first_name ?? '') }}"
                placeholder="First name"
                class="text-input {{ $errors->has('first_name') ? 'field-error' : '' }}"
            >
            @error('first_name')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <div class="field-group">
            <label for="last_name" class="field-label">Last name <span class="text-amber-600">*</span></label>
            <input
                id="last_name"
                type="text"
                name="last_name"
                value="{{ old('last_name', $s->last_name ?? '') }}"
                placeholder="Last name"
                class="text-input {{ $errors->has('last_name') ? 'field-error' : '' }}"
            >
            @error('last_name')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

<section class="form-section">
    <div class="mb-6">
        <p class="section-kicker">Contact</p>
        <h3 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Reliable reach-out details</h3>
        <p class="mt-2 max-w-2xl text-sm leading-7 text-slate-600">Keep the record usable for both operations and support by adding the primary email and any phone number on file.</p>
    </div>

    <div class="form-section-grid">
        <div class="field-group">
            <label for="email" class="field-label">Email <span class="text-amber-600">*</span></label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email', $s->email ?? '') }}"
                placeholder="student@campus.edu"
                class="text-input font-data {{ $errors->has('email') ? 'field-error' : '' }}"
                autocomplete="email"
            >
            @error('email')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <div class="field-group">
            <label for="phone" class="field-label">Phone</label>
            <input
                id="phone"
                type="tel"
                name="phone"
                value="{{ old('phone', $s->phone ?? '') }}"
                placeholder="+1 555 010 2000"
                class="text-input font-data {{ $errors->has('phone') ? 'field-error' : '' }}"
                autocomplete="tel"
            >
            @error('phone')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

<section class="form-section">
    <div class="mb-6">
        <p class="section-kicker">Academic placement</p>
        <h3 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Program, status, and start date</h3>
        <p class="mt-2 max-w-2xl text-sm leading-7 text-slate-600">Assign the student to the right program and lifecycle status so the roster, reporting, and filtering stay accurate.</p>
    </div>

    <div class="form-section-grid">
        <div class="field-group">
            <label for="program_id" class="field-label">Program <span class="text-amber-600">*</span></label>
            <select id="program_id" name="program_id" class="select-input {{ $errors->has('program_id') ? 'field-error' : '' }}">
                <option value="">Select program</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}" {{ (string) old('program_id', $s->program_id ?? '') === (string) $program->id ? 'selected' : '' }}>
                        {{ $program->code }} / {{ $program->name }}
                    </option>
                @endforeach
            </select>
            @error('program_id')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <div class="field-group">
            <label for="status_id" class="field-label">Status <span class="text-amber-600">*</span></label>
            <select id="status_id" name="status_id" class="select-input {{ $errors->has('status_id') ? 'field-error' : '' }}">
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ (string) old('status_id', $s->status_id ?? 1) === (string) $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                @endforeach
            </select>
            @error('status_id')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <div class="field-group">
            <label for="enrollment_date" class="field-label">Enrollment date <span class="text-amber-600">*</span></label>
            <input
                id="enrollment_date"
                type="date"
                name="enrollment_date"
                value="{{ old('enrollment_date', $s->enrollment_date ?? '') }}"
                class="text-input font-data {{ $errors->has('enrollment_date') ? 'field-error' : '' }}"
            >
            @error('enrollment_date')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

<section class="form-section">
    <div class="mb-6">
        <p class="section-kicker">Course load</p>
        <h3 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Attach enrolled courses</h3>
        <p class="mt-2 max-w-2xl text-sm leading-7 text-slate-600">Pick every course that currently belongs to this student record. You can leave this blank and return later if the load is not final yet.</p>
    </div>

    <fieldset class="field-group">
        <legend class="field-label">Selected courses</legend>
        <div class="check-grid">
            @foreach($courses as $course)
                <label class="check-card">
                    <input type="checkbox" name="course_ids[]" value="{{ $course->id }}" {{ in_array($course->id, $selectedCourses) ? 'checked' : '' }}>
                    <div class="min-w-0">
                        <p class="font-data text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $course->code }}</p>
                        <p class="mt-2 text-sm font-semibold text-slate-950">{{ $course->name }}</p>
                        @if($course->description)
                            <p class="mt-1 text-sm leading-6 text-slate-500 trimmed-copy">{{ $course->description }}</p>
                        @endif
                    </div>
                </label>
            @endforeach
        </div>
        @error('course_ids')
            <p class="error-text">{{ $message }}</p>
        @enderror
    </fieldset>
</section>
