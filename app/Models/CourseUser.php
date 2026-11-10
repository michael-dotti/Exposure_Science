<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseUser extends Pivot
{
    protected $table = 'course_user';

    protected static function booted()
    {
        // quando un record viene eliminato dalla tabella pivot
        static::deleted(function ($pivot) {
            // Recupera il corso associato
            $course = Course::find($pivot->course_id);

            if ($course) {
                // Verifica se il corso è rimasto senza docenti
                if ($course->teachers()->count() === 0) {
                    // Elimina il corso
                    $course->delete();
                }
            }
        });
    }
}
