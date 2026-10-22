<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Languages;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Mews\Purifier\Facades\Purifier;

class CoursesController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Course::class);

        $user = auth()->user();

        $teachers = User::permission('teaching')
            ->select('id', 'name', 'surname')
            ->orderBy('surname', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        $courses = Course::visibleTo($user)
            ->with('teachers')
            ->filterByTeacher($request->integer('userId'))
            ->latest('courses.created_at')
            ->Paginate(5)
            ->onEachSide(1)
            ->withQueryString();

        $currentFilters = [];

        if (
            $request->filled('userId') &&
            $selectedTeacher = $teachers->firstWhere(
                'id',
                $request->integer('userId')
            )
        ) {
            $currentFilters[] = [
                'label' => 'Docente',
                'value' => $selectedTeacher->name . ' ' . $selectedTeacher->surname,
            ];
        }

        return view(
            'admin.courses.index',
            compact(
                'courses',
                'teachers',
                'currentFilters'
            )
        );
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
            ->orderBy('surname', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        /*
         * Recupera tutte le lingue definite nell'enum.
         */
        $languages = Languages::cases();

        /*
         * Se l'utente è Admin o Course Admin non viene
         * preselezionato alcun docente.
         *
         * Se è un docente normale viene preselezionato
         * automaticamente il suo ID.
         */
        $user = auth()->user();

        $defaultTeachers = $user->hasAnyRole([
            'admin',
            'course admin',
        ])
            ? []
            : [$user->id];

        return view(
            'admin.courses.create',
            compact(
                'teachers',
                'defaultTeachers',
                'languages'
            )
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

        /*
         * Se l'utente non è Admin o Course Admin,
         * il suo ID deve essere sempre presente
         * tra i docenti del corso.
         */
        $teacherIds = $validated['teachers'];
        $user = auth()->user();

        if (!$user->hasAnyRole(['admin', 'course admin'])) {
            if (!in_array($user->id, $teacherIds)) {
                $teacherIds[] = $user->id;
            }
        }

        DB::transaction(function () use ($courseData, $teacherIds) {
            $course = Course::create($courseData);

            $course->teachers()->attach($teacherIds);
        });

        return redirect()
            ->route('admin.courses.index')
            ->with(
                'success',
                'Corso creato correttamente.'
            );
    }

    public function edit(Course $course)
    {
        Gate::authorize('update', $course);

        $teachers = User::permission('teaching')
            ->select('id', 'name', 'surname')
            ->orderBy('surname', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        /*
         * Recupera tutte le lingue definite nell'enum.
         */
        $languages = Languages::cases();

        $course->load('teachers');

        return view(
            'admin.courses.edit',
            compact(
                'course',
                'teachers',
                'languages'
            )
        );
    }

    public function update(
        CourseRequest $request,
        Course $course
    ) {
        Gate::authorize('update', $course);

        $validated = $request->validated();

        $courseData = collect($validated)
            ->except('teachers')
            ->toArray();

        $courseData['description'] = Purifier::clean(
            $courseData['description']
        );

        /*
         * Se chi modifica non è Admin o Course Admin,
         * deve rimanere tra i docenti del corso.
         */
        $teacherIds = $validated['teachers'];
        $user = auth()->user();

        if (!$user->hasAnyRole(['admin', 'course admin'])) {
            if (!in_array($user->id, $teacherIds)) {
                $teacherIds[] = $user->id;
            }
        }

        DB::transaction(function () use (
            $course,
            $courseData,
            $teacherIds
        ) {
            $course->update($courseData);

            $course->teachers()->sync($teacherIds);
        });

        return redirect()
            ->route('admin.courses.index')
            ->with(
                'success',
                'Corso modificato correttamente.'
            );
    }

    public function destroy(Course $course)
    {
        Gate::authorize('delete', $course);

        DB::transaction(function () use ($course) {
            $course->teachers()->detach();
            $course->delete();
        });

        return $this
            ->redirectBackOrTo('admin.courses.index')
            ->with(
                'success',
                'Corso eliminato correttamente.'
            );
    }
}