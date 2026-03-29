<?php

namespace App\Mcp\Tools;

use App\Models\Student;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Description;

#[Name('list_students')]
#[Description('List students with optional filters. Search by name/ID/email, filter by status (Active, Inactive, Graduated, On Leave) and program code.')]
class ListStudentsTool extends Tool
{
    public function handle(
        ?string $search = null,
        ?string $status = null,
        ?string $program_code = null,
        int $limit = 20
    ): string {
        $students = Student::with(['gender', 'program', 'status', 'courses'])
            ->when($search, fn($q) =>
                $q->where(fn($q) =>
                    $q->whereRaw("LOWER(first_name || ' ' || last_name) LIKE ?", ['%' . strtolower($search) . '%'])
                      ->orWhere('student_id', 'ilike', "%{$search}%")
                      ->orWhere('email', 'ilike', "%{$search}%")
                )
            )
            ->when($status, fn($q) =>
                $q->whereHas('status', fn($q) => $q->where('name', $status))
            )
            ->when($program_code, fn($q) =>
                $q->whereHas('program', fn($q) => $q->where('code', $program_code))
            )
            ->limit($limit)
            ->latest()
            ->get()
            ->map(fn($s) => [
                'id'              => $s->id,
                'student_id'      => $s->student_id,
                'name'            => $s->full_name,
                'gender'          => $s->gender->name,
                'program'         => $s->program->code . ' — ' . $s->program->name,
                'status'          => $s->status->name,
                'email'           => $s->email,
                'phone'           => $s->phone,
                'enrollment_date' => $s->enrollment_date,
                'courses'         => $s->courses->map(fn($c) => $c->code . ' ' . $c->name)->join(', '),
            ]);

        return json_encode([
            'total_students' => Student::count(),
            'returned'       => $students->count(),
            'students'       => $students,
        ], JSON_PRETTY_PRINT);
    }
}
