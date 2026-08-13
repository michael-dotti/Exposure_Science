<?php

namespace App\Http\Controllers\Admin;

// visto che il controller non si trova nella solita cartella, devo improtare il controller di base
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use vendor\laravel\fortify\stubs\PasswordValidationRules;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        // estrae in automatico solo gli utenti che hanno la colonna deleted_at = null
        $users = User::with('roles')
                    ->filterByStatus($request->query('status'))
                    ->orderBy('surname','asc') // ordino in ordine alfabetico, partendo dal cognome
                    ->orderBy('name', 'asc')
                    ->paginate(10)
                    ->withQueryString(); // Mantiene i parametri URL (es. ?status=trashed) navigando tra le pagine della paginazione (altrimenti perdi il filtraggio)

        
        return view('admin.users-management.index',compact('users'));
    }

    public function show()
    {
         dd("TODO");
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users-management.create', compact('roles'));
    }

    public function store()
    {
        dd("TODO");
        // 1) validazione
        $validated = request()->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'surname' => ['required','min:3', 'max:255'],
            'email' => ['required','email', 'max:255', 'min:5', 'unique'], // Diciamo a Laravel: deve essere unica, ma ignora questo utente specifico
            'password' => $this->passwordRules()
        ]);

        // 2) creare nuovo User
        $user = User::create([
            'name' => $validated['name'],
            'surname' => $validated['name'],
            'email' => $validated['email'], 
            'password' => Hash::make($validated['password']),
        ]);
        
        // 3) redirect
        return redirect()->route('admin.users-management.index');
    }
    
   /*  public function edit()
    {
        
    } */

    public function update()
    {
        // usato per cambiare i permessi di uno user dalla pagina admin.users-management.index
        dd("TODO");
    }

    public function destroy(User $user)
    {
        // Grazie al a SoftDeletes, questo NON cancellerà il record,
        // ma imposterà semplicemente il campo deleted_at con la data e ora attuali. 
        $user->delete();

        return redirect()->route('admin.users-management.index');
    }

    public function forceDestroy(User $user)
    {
        // 1) Sgangia le relazioni Molti-a-Molti per non lasciare record orfani
        $user->articles()->detach();
        $user->projects()->detach();
        $user->events_receives()->detach();
        $user->courses()->detach();

        // 2) Forza l'eliminazione definitiva
        $user->forceDelete();

        // 3) Ritorna alal pagina precedente
        return redirect()->back();
    }
    
    public function restore(User $user)
    {
        $user->restore();

        return redirect()->back();
    }
}
