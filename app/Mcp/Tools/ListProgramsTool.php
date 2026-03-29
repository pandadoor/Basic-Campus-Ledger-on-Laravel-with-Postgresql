<?php

namespace App\Mcp\Tools;

use App\Models\Program;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Description;

#[Name('list_programs')]
#[Description('List all academic programs with their code, name, department, and enrolled student count.')]
class ListProgramsTool extends Tool
{
    public function handle(): string
    {
        $programs = Program::withCount('students')->orderBy('code')->get()
            ->map(fn($p) => [
                'id'            => $p->id,
                'code'          => $p->code,
                'name'          => $p->name,
                'department'    => $p->department,
                'student_count' => $p->students_count,
            ]);

        return json_encode(['programs' => $programs], JSON_PRETTY_PRINT);
    }
}
