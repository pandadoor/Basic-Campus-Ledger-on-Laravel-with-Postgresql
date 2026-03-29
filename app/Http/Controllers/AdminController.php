<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Program;
use App\Models\Status;
use App\Models\Student;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'students' => Student::count(),
            'active' => Student::whereHas('status', fn ($query) => $query->where('name', 'Active'))->count(),
            'programs' => Program::count(),
            'courses' => Course::count(),
        ];

        $recentStudents = Student::with(['program', 'status'])
            ->latest()
            ->take(6)
            ->get();

        $programs = Program::withCount('students')
            ->orderBy('code')
            ->take(6)
            ->get();

        $courses = Course::withCount('students')
            ->orderBy('code')
            ->take(6)
            ->get();

        $statusBreakdown = Status::withCount('students')
            ->orderBy('name')
            ->get();

        return view('admin.index', compact(
            'stats',
            'recentStudents',
            'programs',
            'courses',
            'statusBreakdown',
        ));
    }
}
