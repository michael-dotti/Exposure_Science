<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;

class CoursesController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::latest()
            ->filterByTeacher($request->query('userId'))
            ->paginate(6)
            ->withQueryString();

        $teachers = User::select('id', 'name', 'surname')
        ->orderBy('surname','asc')
        ->orderBy('name', 'asc')
        ->get();

        return view('public.courses.index', compact('courses','teachers'));
    }

    public function show(Course $course)
    {
        return view('public.courses.show', ['course' => $course]);
    }
}
