<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mews\Purifier\Facades\Purifier;
use App\Http\Requests\CourseRequest;
use Illuminate\Support\Facades\Gate;

class CoursesController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Course::class);
        
        $user = Auth()->user();

        $teachers = User::permission('teaching')
        ->select('id', 'name', 'surname')
        ->orderBy('surname','asc')
        ->orderBy('name', 'asc')
        ->get();

        $courses = Course::visibleTo($user)
        ->with('teachers')
        ->filterByTeacher($request->integer('userId')) // Lo scope che avevamo creato prima
        ->latest('courses.created_at')
        ->simplePaginate(5)
        ->withQueryString();

        $currentFilters = [];

        if ($request->filled('userId') && $selectedTeacher = $teachers->firstWhere('id', $request->integer('userId'))) {
            $currentFilters[] = [
                'label' => 'Docente',
                'value' => $selectedTeacher->name . ' ' . $selectedTeacher->surname,
            ];
        }

        return view('admin.courses.index', compact('courses', 'teachers', 'currentFilters'));
    }

    public function show(Course $course)
    {
        Gate::authorize('view', $course);

        $course->load('teachers');

        return view(
            'admin.courses.show',
            compact('course')
        );
    }

    public function create()
    {
        Gate::authorize('create', Course::class);

        $teachers = User::permission('teaching')
        ->select('id', 'name', 'surname')
        ->orderBy('surname','asc')
        ->orderBy('name', 'asc')
        ->get();
            

        return view(
            'admin.courses.create',
            compact('teachers')
        );
    }

    public function store(CourseRequest $request)
    {
        Gate::authorize('create', Course::class);

        $validated = $request->validated();

        $courseData = collect($validated)
            ->except('teachers')
            ->toArray();

        $courseData['description'] = Purifier::clean(
            $courseData['description']
        );

        $course = Course::create($courseData);

        $course->teachers()->attach(
            $validated['teachers']
        );

        return redirect()->route('admin.courses.index')
            ->with('success', 'Corso creato correttamente.');
    }

    public function edit(Course $course)
    {
        Gate::authorize('update', $course);

        $teachers = User::permission('teaching')
        ->select('id', 'name', 'surname')
        ->orderBy('surname','asc')
        ->orderBy('name', 'asc')
        ->get();

        $course->load('teachers');

        return view(
            'admin.courses.edit',
            compact('course', 'teachers')
        );
    }

    public function update(CourseRequest $request, Course $course)
    {
        $validated = $request->validated();

        Gate::authorize('update', $course);

        $courseData = collect($validated)
            ->except('teachers')
            ->toArray();

        $courseData['description'] = Purifier::clean(
            $courseData['description']
        );

        $course->update($courseData);

        $course->teachers()->sync(
            $validated['teachers']
        );

        return redirect()->route('admin.courses.index')
            ->with('success', 'Corso modificato correttamente.');
       
    }

    public function destroy(Course $course)
    {
        Gate::authorize('delete', $course);

        $course->teachers()->detach();
        $course->news()->detach();
        $course->delete();

        return $this->redirectBackOrTo('admin.courses.index')->with(
                'success',
                'Corso eliminato correttamente.'
            );
    }
}