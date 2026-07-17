<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image;

class UserController extends Controller
{

    public function store(){
        // 1) validazione
        // 2) intervention Image (se c'è foto profilo)
        // 3) caricare la foto profilo nello storage
        // 4) creare nuovo User
        // 5) redirect
    }

    public function update(User $user){
        // validate 
        $validated = request()->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'surname' => ['required','min:3', 'max:255'],
            'email' => ['required','email', 'max:255', 'min:5', Rule::unique('users')->ignore($user->id)], // Diciamo a Laravel: deve essere unica, ma ignora questo utente specifico
            'website' => ['nullable','url','max:511'],
            'bio' => ['nullable','max:5000'],
            'profile_photo_path' => ['nullable', 'image', 'max:5120'],
        ]);
 
        //Caso 1: l'utente ha caricato una NUOVA immagine
        // carica l'immagine e salva il path
        if (request()->hasFile('profile_photo_path')) {
            // Elimina la vecchia immagine
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // cambiamo le dimensioni dell'immagine, rendiamola .webp riducento la qualità dell'immagine all'80%, creiamole un percorso
            $file = request()->file('profile_photo_path');
            $image = Image::read($file);
            $image->cover(200,200);
            $encoded = $image->toWebp(80);
            $fileName = 'uploads/users/profileImage/' . uniqid() . '.webp' ;
            
            // salviamo l'immagine nella cartella public nel percorso scelto prima, mettiamo il percorso nella riga corrispondente della tabella USer
            Storage::disk('public')->put($fileName, $encoded->toString());
            $validated['profile_photo_path'] = $fileName;
        }
        // Caso 2: L'utente ha cliccato "elimina" (uso il flag hidden)
        elseif (request()->input('remove_photo') == '1') {
            if ($user->profile_photo_path){
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // setto a null "l'immagine" nel database
            $validated['profile_photo_path'] = null;
        }
        // Caso 3: l'utente non ha toccato nulla
        else {
            // Rimuovo il campo dall'array cosi che il valore attuale non venga modificato
            unset($validated['profile_photo_path']);
        }

        // update user
         $user->update($validated);
         
        // redirect
        return redirect('/dashboard');
        
    }

    
}
