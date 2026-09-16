<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function index(Request $request)
    {
        $selectedTeacherId = $request->query('userId');

        $courses = Course::latest()
            ->filterByTeacher($selectedTeacherId)
            ->paginate(2)
            ->onEachSide(1)
            ->withQueryString();

        $teachers = User::select('id', 'name', 'surname')
            ->orderBy('surname', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        $currentFilters = [];

        if ($selectedTeacherId) {
            $selectedTeacher = $teachers->first(function ($teacher) use ($selectedTeacherId) {
                return (string) $teacher->id === (string) $selectedTeacherId;
            });

            if ($selectedTeacher) {
                $currentFilters[] = [
                    'label' => 'Docente',
                    'value' => trim(
                        $selectedTeacher->name . ' ' . $selectedTeacher->surname
                    ),
                ];
            }
        }

        return view('public.courses.index', compact(
            'courses',
            'teachers',
            'currentFilters'
        ));
    }

    public function show(Course $course)
    {
        return view('public.courses.show', [
            'course' => $course,
        ]);
    }
}