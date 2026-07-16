<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = Course::all();

        return view('public.courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        return view('public.courses.show', ['course' => $course]);
    }
}
