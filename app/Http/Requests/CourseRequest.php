<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;
use App\Models\User;


class CourseRequest extends FormRequest
{
   /**
     * Determina se l'utente è autorizzato ad effettuare questa richiesta.
     */
    public function authorize(): bool
    {
        // Impostata a true se l'accesso alla rotta è già protetto da middleware
        return true; 
    }

    /**
     * Regole di validazione applicate alla richiesta.
     */
    public function rules(): array
    {
        // Se siamo in fase di update, $this->course restituirà l'istanza del corso dalla rotta.
        // Se siamo in fase di store, $this->course sarà null.
        $courseId = $this->course ? $this->course->id : null;

        return [
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
                Rule::unique('courses', 'code')->ignore($courseId),
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
                Rule::in(User::permission('teaching')->pluck('id')),
            ],
        ];
    }

    /**
     * Messaggi di errore personalizzati per le regole di validazione.
     */
    public function messages(): array
    {
        return [
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
        ];
    }
}
