<?php

namespace App\Mcp\Tools;

use App\Models\Course;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Description;

#[Name('list_courses')]
#[Description('List all available courses with their code, name, description, and enrolled student count.')]
class ListCoursesTool extends Tool
{
    public function handle(): string
    {
        $courses = Course::withCount('students')->orderBy('code')->get()
            ->map(fn($c) => [
                'id'            => $c->id,
                'code'          => $c->code,
                'name'          => $c->name,
                'description'   => $c->description,
                'student_count' => $c->students_count,
            ]);

        return json_encode(['courses' => $courses], JSON_PRETTY_PRINT);
    }
}
