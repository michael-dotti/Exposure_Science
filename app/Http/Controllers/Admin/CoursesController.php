<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mews\Purifier\Facades\Purifier;

class CoursesController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $teachers = User::select(
            'id',
            'name',
            'surname'
        )
            ->whereHas('courses')
            ->orderBy('name')
            ->orderBy('surname')
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
        $teachers = User::select(
            'id',
            'name',
            'surname'
        )
            ->orderBy('name')
            ->orderBy('surname')
            ->get();

        return view(
            'admin.courses.create',
            compact('teachers')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                ],

                'language' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'code' => [
                    'required',
                    'string',
                    'max:10',
                    'unique:courses,code',
                ],

                'points' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:255',
                ],

                'semester' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:255',
                ],

                'duration' => [
                    'required',
                    'integer',
                    'min:1',
                ],

                'description' => [
                    'required',
                    'string',
                ],

                'teachers' => [
                    'required',
                    'array',
                    'min:1',
                ],

                'teachers.*' => [
                    'integer',
                    'distinct',
                    'exists:users,id',
                ],
            ],
            [
                'title.required' => 'Il titolo è obbligatorio.',
                'title.min' => 'Il titolo deve contenere almeno 3 caratteri.',
                'title.max' => 'Il titolo può contenere al massimo 255 caratteri.',

                'language.required' => 'La lingua è obbligatoria.',
                'language.max' => 'La lingua può contenere al massimo 255 caratteri.',

                'code.required' => 'Il codice è obbligatorio.',
                'code.max' => 'Il codice può contenere al massimo 10 caratteri.',
                'code.unique' => 'Esiste già un corso con questo codice.',

                'points.required' => 'Il numero di crediti è obbligatorio.',
                'points.integer' => 'I crediti devono essere un numero intero.',
                'points.min' => 'I crediti devono essere maggiori di zero.',
                'points.max' => 'I crediti non possono essere maggiori di 255.',

                'semester.required' => 'Il semestre è obbligatorio.',
                'semester.integer' => 'Il semestre deve essere un numero intero.',
                'semester.min' => 'Il semestre deve essere maggiore di zero.',
                'semester.max' => 'Il semestre non può essere maggiore di 255.',

                'duration.required' => 'La durata è obbligatoria.',
                'duration.integer' => 'La durata deve essere un numero intero.',
                'duration.min' => 'La durata deve essere maggiore di zero.',

                'description.required' => 'La descrizione è obbligatoria.',

                'teachers.required' => 'Devi selezionare almeno un docente.',
                'teachers.array' => 'La selezione dei docenti non è valida.',
                'teachers.min' => 'Devi selezionare almeno un docente.',
                'teachers.*.integer' => 'Uno dei docenti selezionati non è valido.',
                'teachers.*.distinct' => 'Lo stesso docente è stato selezionato più volte.',
                'teachers.*.exists' => 'Uno dei docenti selezionati non è valido.',
            ]
        );

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

        return redirect('/admin/courses')
            ->with(
                'success',
                'Corso creato correttamente.'
            );
    }

    public function edit(Course $course)
    {
        $teachers = User::select(
            'id',
            'name',
            'surname'
        )
            ->orderBy('name')
            ->orderBy('surname')
            ->get();

        $course->load('teachers');

        return view(
            'admin.courses.edit',
            compact('course', 'teachers')
        );
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate(
            [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                ],

                'language' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'code' => [
                    'required',
                    'string',
                    'max:10',
                    Rule::unique('courses', 'code')
                        ->ignore($course->id),
                ],

                'points' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:255',
                ],

                'semester' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:255',
                ],

                'duration' => [
                    'required',
                    'integer',
                    'min:1',
                ],

                'description' => [
                    'required',
                    'string',
                ],

                'teachers' => [
                    'required',
                    'array',
                    'min:1',
                ],

                'teachers.*' => [
                    'integer',
                    'distinct',
                    'exists:users,id',
                ],
            ],
            [
                'title.required' => 'Il titolo è obbligatorio.',
                'title.min' => 'Il titolo deve contenere almeno 3 caratteri.',
                'title.max' => 'Il titolo può contenere al massimo 255 caratteri.',

                'language.required' => 'La lingua è obbligatoria.',
                'language.max' => 'La lingua può contenere al massimo 255 caratteri.',

                'code.required' => 'Il codice è obbligatorio.',
                'code.max' => 'Il codice può contenere al massimo 10 caratteri.',
                'code.unique' => 'Esiste già un corso con questo codice.',

                'points.required' => 'Il numero di crediti è obbligatorio.',
                'points.integer' => 'I crediti devono essere un numero intero.',
                'points.min' => 'I crediti devono essere maggiori di zero.',
                'points.max' => 'I crediti non possono essere maggiori di 255.',

                'semester.required' => 'Il semestre è obbligatorio.',
                'semester.integer' => 'Il semestre deve essere un numero intero.',
                'semester.min' => 'Il semestre deve essere maggiore di zero.',
                'semester.max' => 'Il semestre non può essere maggiore di 255.',

                'duration.required' => 'La durata è obbligatoria.',
                'duration.integer' => 'La durata deve essere un numero intero.',
                'duration.min' => 'La durata deve essere maggiore di zero.',

                'description.required' => 'La descrizione è obbligatoria.',

                'teachers.required' => 'Devi selezionare almeno un docente.',
                'teachers.array' => 'La selezione dei docenti non è valida.',
                'teachers.min' => 'Devi selezionare almeno un docente.',
                'teachers.*.integer' => 'Uno dei docenti selezionati non è valido.',
                'teachers.*.distinct' => 'Lo stesso docente è stato selezionato più volte.',
                'teachers.*.exists' => 'Uno dei docenti selezionati non è valido.',
            ]
        );

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

        return redirect('/admin/courses')
            ->with(
                'success',
                'Corso modificato correttamente.'
            );
    }

    public function destroy(Course $course)
    {
        $course->teachers()->detach();
        $course->news()->detach();
        $course->delete();

        return redirect('/admin/courses')
            ->with(
                'success',
                'Corso eliminato correttamente.'
            );
    }
}