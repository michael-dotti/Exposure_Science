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
                Rule::unique('courses', 'title')->ignore($this->course?->id),
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
                'max:20000'
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
            // Messaggio specifico per il controllo sul permesso "teaching"
            'teachers.*.in' => 'Uno dei docenti selezionati non ha i permessi per insegnare.',
            
            'teachers.required' => 'Devi selezionare almeno un docente per il corso.',
        ];
    }
}
