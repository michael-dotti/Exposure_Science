<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mews\Purifier\Facades\Purifier;
use App\Http\Requests\CourseRequest;

class CoursesController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $teachers = User::permission('teaching')
        ->select('id', 'name', 'surname')
        ->orderBy('surname','asc')
        ->orderBy('name', 'asc')
        ->get();

        $courses = $user
            ->courses()
            ->with('teachers')
            ->when(
                $request->filled('userId'),
                function ($query) use ($request) {
                    $query->whereHas(
                        'teachers',
                        function ($teacherQuery) use ($request) {
                            $teacherQuery->where(
                                'users.id',
                                $request->integer('userId')
                            );
                        }
                    );
                }
            )
            ->latest('courses.created_at')
            ->simplePaginate(5)
            ->withQueryString();

        return view(
            'admin.courses.index',
            compact('courses', 'teachers')
        );
    }

    public function show(Course $course)
    {
        $course->load('teachers');

        return view(
            'admin.courses.show',
            compact('course')
        );
    }

    public function create()
    {
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
        $course->teachers()->detach();
        $course->news()->detach();
        $course->delete();

        return $this->redirectBackOrTo('admin.courses.index')->with(
                'success',
                'Corso eliminato correttamente.'
            );
    }
}