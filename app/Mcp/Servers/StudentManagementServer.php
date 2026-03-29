<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\CreateStudentTool;
use App\Mcp\Tools\GetStudentTool;
use App\Mcp\Tools\ListCoursesTool;
use App\Mcp\Tools\ListProgramsTool;
use App\Mcp\Tools\ListStudentsTool;
use Laravel\Mcp\Server as McpServer;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

#[Name('Student Management')]
#[Version('1.0.0')]
#[Description('MCP server for the Student Management System. Provides tools to query and manage students, programs, and courses stored in PostgreSQL using a 4NF-compliant schema.')]
class StudentManagementServer extends McpServer
{
    protected array $tools = [
        ListStudentsTool::class,
        GetStudentTool::class,
        CreateStudentTool::class,
        ListProgramsTool::class,
        ListCoursesTool::class,
    ];
}
