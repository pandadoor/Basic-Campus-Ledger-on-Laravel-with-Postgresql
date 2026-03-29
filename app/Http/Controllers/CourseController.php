<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    private function resolveRedirectRoute(Request $request, string $default): string
    {
        $allowedRoutes = [$default, 'admin.index'];
        $requestedRoute = $request->input('redirect_route');

        return in_array($requestedRoute, $allowedRoutes, true) ? $requestedRoute : $default;
    }

    public function index()
    {
        $courses = Course::withCount('students')->orderBy('code')->get();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'        => 'required|unique:courses|max:20',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $errorBag = $request->input('error_bag');
        $data = $errorBag ? $validator->validateWithBag($errorBag) : $validator->validate();

        Course::create($data);

        return redirect()
            ->route($this->resolveRedirectRoute($request, 'courses.index'))
            ->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'code'        => "required|unique:courses,code,{$course->id}|max:20",
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);
        $course->update($request->only('code', 'name', 'description'));
        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        if ($course->students()->exists()) {
            return back()->with('error', 'Cannot delete a course with enrolled students.');
        }
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted.');
    }
}
