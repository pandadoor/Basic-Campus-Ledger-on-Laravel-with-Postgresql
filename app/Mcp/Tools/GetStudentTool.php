<?php

namespace App\Mcp\Tools;

use App\Models\Student;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Description;

#[Name('get_student')]
#[Description('Get full details of a single student by their student_id, numeric database ID, or email. Returns all fields including enrolled courses with grades.')]
class GetStudentTool extends Tool
{
    public function handle(string $identifier): string
    {
        $student = Student::with(['gender', 'program', 'status', 'courses'])
            ->where('student_id', $identifier)
            ->orWhere('id', is_numeric($identifier) ? $identifier : 0)
            ->orWhere('email', $identifier)
            ->first();

        if (! $student) {
            return json_encode(['error' => "Student not found: {$identifier}"]);
        }

        return json_encode([
            'id'              => $student->id,
            'student_id'      => $student->student_id,
            'first_name'      => $student->first_name,
            'last_name'       => $student->last_name,
            'full_name'       => $student->full_name,
            'gender'          => $student->gender->name,
            'program'         => [
                'code'       => $student->program->code,
                'name'       => $student->program->name,
                'department' => $student->program->department,
            ],
            'status'          => $student->status->name,
            'email'           => $student->email,
            'phone'           => $student->phone,
            'enrollment_date' => $student->enrollment_date,
            'courses'         => $student->courses->map(fn($c) => [
                'code'  => $c->code,
                'name'  => $c->name,
                'grade' => $c->pivot->grade,
            ]),
        ], JSON_PRETTY_PRINT);
    }
}
