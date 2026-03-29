<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgramController extends Controller
{
    private function resolveRedirectRoute(Request $request, string $default): string
    {
        $allowedRoutes = [$default, 'admin.index'];
        $requestedRoute = $request->input('redirect_route');

        return in_array($requestedRoute, $allowedRoutes, true) ? $requestedRoute : $default;
    }

    public function index()
    {
        $programs = Program::withCount('students')->orderBy('code')->get();
        return view('programs.index', compact('programs'));
    }

    public function create()
    {
        return view('programs.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'       => 'required|unique:programs|max:20',
            'name'       => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
        ]);

        $errorBag = $request->input('error_bag');
        $data = $errorBag ? $validator->validateWithBag($errorBag) : $validator->validate();

        Program::create($data);

        return redirect()
            ->route($this->resolveRedirectRoute($request, 'programs.index'))
            ->with('success', 'Program created successfully.');
    }

    public function edit(Program $program)
    {
        return view('programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $request->validate([
            'code'       => "required|unique:programs,code,{$program->id}|max:20",
            'name'       => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
        ]);
        $program->update($request->only('code', 'name', 'department'));
        return redirect()->route('programs.index')->with('success', 'Program updated successfully.');
    }

    public function destroy(Program $program)
    {
        if ($program->students()->exists()) {
            return back()->with('error', 'Cannot delete a program with enrolled students.');
        }
        $program->delete();
        return redirect()->route('programs.index')->with('success', 'Program deleted.');
    }
}
