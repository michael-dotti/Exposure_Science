<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function update(User $user){
        // validate 
        $validated = request()->validate([
        'name' => ['required', 'min:3', 'max:255'],
        'surname' => ['required','min:3', 'max:255'],
        'email' => ['required','email', 'max:255', 'min:5', Rule::unique('users')->ignore($user->id)], // Diciamo a Laravel: deve essere unica, ma ignora questo utente specifico
        'bio' => ['nullable','max:5000'],
        'profile_photo_path' => ['nullable', 'image', 'max:2048'],
        ]);

         // Rimuoviamo la foto dall'array principale per evitare che sovrascriva con NULL
        // Se l'utente carica una nuova foto, la riaggiungeremo dopo.
        unset($validated['profile_photo_path']);
        
        // upload the image and save the path
        if (request()->hasFile('profile_photo_path')) {
            // Elimina la vecchia immagine (ma occhio a non eliminare la default.png!)
            if ($user->profile_photo_path ) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            
            $validated['profile_photo_path'] = request()->file('profile_photo_path')->store('profileImage', 'public');
        }

        // update user
         $user->update($validated);
         
        // redirect
        return redirect('/dashboard');
        
    }
}
