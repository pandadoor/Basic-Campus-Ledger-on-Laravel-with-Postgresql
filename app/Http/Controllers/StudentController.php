<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Gender;
use App\Models\Program;
use App\Models\Status;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private function formData(): array
    {
        return [
            'genders'  => Gender::all(),
            'programs' => Program::orderBy('name')->get(),
            'statuses' => Status::all(),
            'courses'  => Course::orderBy('name')->get(),
        ];
    }

    public function index(Request $request)
    {
        $students = Student::with(['gender', 'program', 'status'])
            ->when($request->search, fn($q) =>
                $q->where(fn($q) =>
                    $q->whereRaw("LOWER(first_name || ' ' || last_name) LIKE ?", ['%' . strtolower($request->search) . '%'])
                      ->orWhere('student_id', 'ilike', "%{$request->search}%")
                      ->orWhere('email', 'ilike', "%{$request->search}%")
                )
            )
            ->when($request->status, fn($q) =>
                $q->whereHas('status', fn($q) => $q->where('name', $request->status))
            )
            ->when($request->program, fn($q) =>
                $q->where('program_id', $request->program)
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total'     => Student::count(),
            'active'    => Student::whereHas('status', fn($q) => $q->where('name', 'Active'))->count(),
            'graduated' => Student::whereHas('status', fn($q) => $q->where('name', 'Graduated'))->count(),
            'inactive'  => Student::whereHas('status', fn($q) => $q->whereIn('name', ['Inactive', 'On Leave']))->count(),
        ];

        return view('students.index', array_merge(compact('students', 'stats'), $this->formData()));
    }

    public function create()
    {
        return view('students.create', $this->formData());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'      => 'required|unique:students|max:30',
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'gender_id'       => 'required|exists:genders,id',
            'program_id'      => 'required|exists:programs,id',
            'status_id'       => 'required|exists:statuses,id',
            'email'           => 'required|email|unique:students',
            'phone'           => 'nullable|string|max:30',
            'enrollment_date' => 'required|date',
            'course_ids'      => 'nullable|array',
            'course_ids.*'    => 'exists:courses,id',
        ]);

        $student = Student::create($data);
        $student->courses()->sync($request->course_ids ?? []);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['gender', 'program', 'status', 'courses']);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $student->load('courses');
        return view('students.edit', array_merge(compact('student'), $this->formData()));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'student_id'      => "required|unique:students,student_id,{$student->id}|max:30",
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'gender_id'       => 'required|exists:genders,id',
            'program_id'      => 'required|exists:programs,id',
            'status_id'       => 'required|exists:statuses,id',
            'email'           => "required|email|unique:students,email,{$student->id}",
            'phone'           => 'nullable|string|max:30',
            'enrollment_date' => 'required|date',
            'course_ids'      => 'nullable|array',
            'course_ids.*'    => 'exists:courses,id',
        ]);

        $student->update($data);
        $student->courses()->sync($request->course_ids ?? []);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
