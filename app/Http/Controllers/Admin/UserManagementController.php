<?php

namespace App\Http\Controllers\Admin;

// visto che il controller non si trova nella solita cartella, devo improtare il controller di base
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    use PasswordValidationRules;

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

    public function show(User $user)
    {
        $user->load(['curriculum', 'roles']);

        $roles = Role::all();

        return view('admin.users-management.show',compact('user','roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users-management.create', compact('roles'));
    }

    public function store()
    {
        // 1) validazione
        $validated = request()->validate([
            'name' => ['required','string', 'min:3', 'max:255'],
            'surname' => ['required','string','min:3', 'max:255'],
            'email' => ['required','email', 'max:255', 'min:5', 'unique:users,email'], // Diciamo a Laravel: deve essere unica, ma ignora questo utente specifico
            'roles' =>  ['nullable', 'array'],
            'roles.*' => ['required', 'exists:roles,id'],
            'password' => $this->passwordRules()
        ]);

        
        $user = DB::transaction(function () use ($validated) {
            // 2) creare nuovo User
            $user = User::create([
                'name' => $validated['name'],
                'surname' => $validated['surname'],
                'email' => $validated['email'], 
                'password' => Hash::make($validated['password']),
            ]);

            // 3) Assegna ruoli (assegna il ruolo 'researcher' se l'array è vuoto)
            if (!empty($validated['roles'])) {
                $user->assignRole(array_map('intval', $validated['roles']));
            } else {
                $user->assignRole('researcher');
            }

            return $user;// Nota Bene: le variabili definite dentro a DB::transaction() non sono utilizzabili all'esterno a meno che non le restituisci
        });

        // 4) redirect
        return redirect()->route('admin.users-management.index')->with('success', 'Nuovo utente creato: ' . $user->name . ' ' . $user->surname . '.');
    }
    

    public function update(User $user)
    {
        // 1) Validazione
        $validated = request()->validate([
            'roles' => ['nullable', 'array'],  // 'nullable' permette che l'array sia vuoto
            'roles.*' => ['exists:roles,id'],  // Verifica che l'ID passato esista nella tabella roles
        ]);

        // 2) Estraggo i ruoli
        $roles = $validated['roles'] ?? [];

        // 3) converto i ruoli in int 
        $user->syncRoles(array_map('intval', $roles));

        return redirect()->route('admin.users-management.index')->with('success', 'I ruoli di ' . $user->name . ' ' . $user->surname . ' sono stati aggiornati con successo.');

    }

    public function destroy(User $user)
    {
        // Grazie al a SoftDeletes, questo NON cancellerà il record,
        // ma imposterà semplicemente il campo deleted_at con la data e ora attuali. 
        $user->delete();

        return redirect()->back();
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

        // 3) Ritorna alla pagina precedente
        return redirect()->back();
    }
    
    public function restore(User $user)
    {
        $user->restore();

        return redirect()->back();
    }
}
