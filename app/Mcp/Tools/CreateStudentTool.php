<?php

namespace App\Mcp\Tools;

use App\Models\Course;
use App\Models\Gender;
use App\Models\Program;
use App\Models\Status;
use App\Models\Student;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Description;

#[Name('create_student')]
#[Description('Create a new student. Required: student_id, first_name, last_name, email, gender (Male/Female/Other), program_code (e.g. BSCS), enrollment_date (YYYY-MM-DD). Optional: status, phone, course_codes (comma-separated e.g. CS101,MATH101).')]
class CreateStudentTool extends Tool
{
    public function handle(
        string $student_id,
        string $first_name,
        string $last_name,
        string $email,
        string $gender,
        string $program_code,
        string $enrollment_date,
        string $status = 'Active',
        ?string $phone = null,
        string $course_codes = ''
    ): string {
        if (Student::where('student_id', $student_id)->exists()) {
            return json_encode(['error' => "Student ID {$student_id} already exists."]);
        }
        if (Student::where('email', $email)->exists()) {
            return json_encode(['error' => "Email {$email} already exists."]);
        }

        $genderModel  = Gender::where('name', $gender)->first();
        $programModel = Program::where('code', $program_code)->first();
        $statusModel  = Status::where('name', $status)->first();

        if (! $genderModel)  return json_encode(['error' => "Gender '{$gender}' not found. Options: Male, Female, Other"]);
        if (! $programModel) return json_encode(['error' => "Program '{$program_code}' not found."]);
        if (! $statusModel)  return json_encode(['error' => "Status '{$status}' not found. Options: Active, Inactive, Graduated, On Leave"]);

        $student = Student::create([
            'student_id'      => $student_id,
            'first_name'      => $first_name,
            'last_name'       => $last_name,
            'email'           => $email,
            'phone'           => $phone,
            'gender_id'       => $genderModel->id,
            'program_id'      => $programModel->id,
            'status_id'       => $statusModel->id,
            'enrollment_date' => $enrollment_date,
        ]);

        if ($course_codes) {
            $codes   = array_map('trim', explode(',', $course_codes));
            $courses = Course::whereIn('code', $codes)->pluck('id');
            $student->courses()->sync($courses);
        }

        return json_encode([
            'success'    => true,
            'message'    => "Student {$student->full_name} created successfully.",
            'student_id' => $student->student_id,
            'id'         => $student->id,
        ], JSON_PRETTY_PRINT);
    }
}
