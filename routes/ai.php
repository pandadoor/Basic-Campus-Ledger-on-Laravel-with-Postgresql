<?php

use Laravel\Mcp\Facades\Mcp;
use App\Mcp\Servers\StudentManagementServer;

Mcp::local('student-management', StudentManagementServer::class);
